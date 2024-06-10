<?php

namespace App\Http\Controllers;

use App\Models\DetailPenjualan;
use App\Models\LogStock;
use App\Models\Pelanggan;
use App\Models\Penjualan;
use App\Models\Produk;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;

class PenjualanController extends Controller
{
    public function index()
    {
        $products = Produk::all();
        $wallet = Auth::user()->wallet;
        $balance = $wallet ? $wallet->balance : 0;
        return view('pages.penjualan.index', compact('products', 'balance'));
    }

    public function paymentHistory()
    {
        $penjualanTransaction = Penjualan::all();
        $detailTransaction = DetailPenjualan::all();
        $logStockOut = LogStock::where("status", "out")->get();
        return view('pages.penjualan.history', compact("detailTransaction", "penjualanTransaction", "logStockOut"));
    }

    public function createInvoice(Request $request)
    {
        $products = [];
        $codes = $request->code;
        $quantitys = $request->quantity;
        $discounts = $request->discount;

        foreach ($codes as $index => $code) {
            $products[] = [
                "code" => $code,
                "quantity" => $quantitys[$index],
                "discount" => $discounts[$index]
            ];
        }
        $codesToSearch = array_column($products, 'code');
        $items = Produk::whereIn('code', $codesToSearch)->get();

        $errorMessages = [];

        foreach ($products as $product) {
            $found = false;
            foreach ($items as $item) {
                if ($product["code"] == $item->code) {
                    $found = true;
                    if ($product["quantity"] > $item->stock) {
                        $errorMessages[] = "Stok produk '" . $item->product_name . "' dengan kode '" . $product["code"] . "' tidak mencukupi";
                    }
                    break;
                }
            }
            if (!$found) {
                $errorMessages[] = $product["code"];
            }
        }

        if (!empty($errorMessages)) {
            return back()->with("fail", $errorMessages);
        }

        $name = $request->name;
        $phone = $request->phone;
        $address = $request->address;

        session([
            "produk" => $products,
            "pelanggan" => [
                "name" => $name,
                "phone" => $phone,
                "address" => $address
            ]
        ]);
        return view("pages.penjualan.invoice", compact(
            "name",
            "phone",
            "address",
            "products",
            "items",
        ));
    }

    public function downloadPdf()
    {
        $inputProducts = session("produk");
        $customer = session('pelanggan');

        // dd($inputProducts);
        $total_price = 0;
        foreach ($inputProducts as $product) {
            $products = Produk::all();

            foreach ($products as $item) {
                if ($product["code"] == $item->code) {
                    $price = $product["quantity"] * $item->price;
                    $total_price += $price;
                }
            }
        }
        $pdf = PDF::loadView('pages.penjualan.pdf', compact('products', 'inputProducts', 'total_price', 'customer'));
        return $pdf->download('Bukti_pembayaran.pdf');
    }

    public function confirmPayment()
    {
        $products = session("produk");
        $codesToSearch = array_column($products, 'code');
        $items = Produk::whereIn('code', $codesToSearch)->get();
        $total_price = 0;
        foreach ($items as $item) {
            foreach ($products as $product) {
                if ($product["code"] == $item->code) {
                    $price = $product["quantity"] * $item->price;
                    $total_price += $price;
                }
            }
        }

        $user = Auth::user();
        $wallet = $user->wallet;

        if (!$wallet || $wallet->balance < $total_price) {
            return redirect()->back()->with('fail', 'Saldo tidak mencukupi untuk melakukan transaksi.');
        }

        $customers = session("pelanggan");
        if ($customers["address"] == null) {
            $customer = Pelanggan::create([
                "customer_name" => $customers["name"],
                "no_phone" => $customers["phone"],
            ]);
        } else {
            $customer = Pelanggan::create([
                "customer_name" => $customers["name"],
                "no_phone" => $customers["phone"],
                "address" => $customers["address"]
            ]);
        }

        DB::transaction(function () use ($wallet, $total_price, $customer, $items, $products) {
            $penjualan = Penjualan::create([
                "pelanggan_id" => $customer->id,
                'sale_date' => now(),
                'total_price' => $total_price
            ]);

            foreach ($items as $item) {
                foreach ($products as $product) {
                    if ($product["code"] == $item->code) {
                        DetailPenjualan::create([
                            'penjualan_id' => $penjualan->id,
                            'produk_id' => $item->id,
                            'total_product' => $product["quantity"],
                            'subtotal' => $item->price * $product["quantity"]
                        ]);

                        $productUpdate = Produk::find($item->id);
                        $stock = $productUpdate->stock - $product["quantity"];
                        $productUpdate->update([
                            "stock" => $stock
                        ]);

                        LogStock::create([
                            'user_id' => Auth::user()->id,
                            'product_id' => $item->id,
                            'total_stock' => $product["quantity"],
                            'status' => "out"
                        ]);
                    }
                }
            }

            $wallet->balance -= $total_price;
            $wallet->save();
        });

        return redirect()->route("penjualan")->with("success", "Transaksi berhasil! Saldo Anda saat ini: Rp " . number_format($wallet->balance, 0, ',', '.'));
    }
}
