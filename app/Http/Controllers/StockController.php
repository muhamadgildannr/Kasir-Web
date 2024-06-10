<?php

namespace App\Http\Controllers;

use App\Models\LogStock;
use App\Models\Produk;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Stocks\StocksExport;
use Illuminate\Support\Facades\Auth;


class StockController extends Controller
{
    public function index()
    {
        $stockList = Produk::all();
        return view("pages.stock.index", compact("stockList"));
    }

    public function stockIn()
    {
        $stockInList = LogStock::where("status", "=", "in")->get();
        return view("pages.stock.stock_in", compact("stockInList"));
    }
    public function stockOut()
    {
        $stockOutList = LogStock::where("status", "=", "out")->get();
        return view("pages.stock.stock_out", compact("stockOutList"));
    }

    public function store(Request $request)
    {
        $request->validate([
            "product_name" => "required",
            "price" => "required",
            "stock" => "required"
        ]);

        $now = Carbon::now();
        $yearMonthDay = $now->format('y') . $now->format('m') . $now->format('d');
        $producutCount = Produk::count();
        $code = false;

        if ($producutCount == 0) {
            $code = "P".$yearMonthDay."1";
        } else {
            $code = "P" . $yearMonthDay . ($producutCount + 1);
        }   

        $product = Produk::create([
            "product_name" => $request->product_name,
            "price" => $request->price,
            "stock" => $request->stock,
            "code" => $code
        ]);

        LogStock::create([
            'user_id' => Auth::user()->id,
            'product_id' => $product->id,
            'total_stock' => $product->stock,
            'description' => $request->description
        ]);

        return back()->with("success", "Berhasil menambah Product baru");
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            "product_name" => "required",
            "price" => "required",
            // "stock" => "required"
        ]);

        $stock = Produk::find($id);
        $stock->update([
            "product_name" => $request->product_name,
            "price" => $request->price,
            // "stock" => $request->stock
        ]);
        return back()->with("success", "Berhasil merubah Produck");
    }

    public function updateStock(Request $request, $id)
    {
        $request->validate([
            "stock" => "required"
        ]);

        if ($request->stock < 1) {
            return back()->with("err", "Gagal, isi input stock dengan benar!");
        }
        $stock = Produk::find($id);
        $stock->update([
            "stock" => $stock->stock + $request->stock
        ]);

        LogStock::create([
            'user_id' => Auth::user()->id,
            'product_id' => $stock->id,
            'total_stock' => $request->stock,
            'description' => $request->description
        ]);


        return back()->with("success", "Berhasil menambah Stock baru");
    }


}
