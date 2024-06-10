<?php

namespace Database\Seeders;

use App\Models\LogStock;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Produk;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();
        $yearMonthDay = $now->format('y') . $now->format('m').  $now->format('d');
        $firstCode = "P" . $yearMonthDay . "1";
        $secondCode = "P" . $yearMonthDay . "2";
        $firstProduct = Produk::create([
            'nama_produk' => 'Steamboat',
            'harga' => 15000,
            'stok' => 10,
            'code' => $firstCode
        ]);
        $secondProduct = Produk::create([
            'nama_produk' => 'Salad Jelly',
            'harga' => 15000,
            'stok' => 50,
            'code' => $secondCode
        ]);
        LogStock::create([
            'user_id' => 1,
            'produks_id' => $firstProduct->id,
            'description' => 'Produk Populer',
            'total_stock' => $firstProduct->stok,
        ]);
        LogStock::create([
            'user_id' => 1,
            'produks_id' => $secondProduct->id,
            'description' => 'Produk Baru',
            'total_stock' => $secondProduct->stok,
        ]);
    }
}
