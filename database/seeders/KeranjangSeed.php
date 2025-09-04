<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class KeranjangSeed extends Seeder
{
    public function run()
    {
        // Hapus semua data dan reset AUTO_INCREMENT
        DB::table('lixiudiy_keranjang')->truncate();

        // Ambil semua produk
        $produk = DB::table('lixiudiy_produk')->get();

        $keranjangs = [];

        for ($i = 0; $i < 300; $i++) {
            $randomProduk = $produk->random();

            $jumlah = rand(1, 5);
            $keranjangs[] = [
                'keranjang_produk' => $randomProduk->produk_id,
                'keranjang_customer' => rand(1, 205), // customer 1-205
                'keranjang_jumlah' => $jumlah,
                'keranjang_total_harga' => $jumlah * $randomProduk->produk_harga,
                'keranjang_tanggal' => now()->subDays(rand(0, 30)),
                'keranjang_status' => '1',
            ];
        }

        // Insert ke DB
        DB::table('lixiudiy_keranjang')->insert($keranjangs);
    }
}
