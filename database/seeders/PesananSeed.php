<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PesananSeed extends Seeder
{
    public function run()
    {
        // Hapus data lama dan reset auto increment
        DB::table('lixiudiy_pesanan')->truncate();

        // Ambil semua keranjang
        $keranjangs = DB::table('lixiudiy_keranjang')->get();

        // Kelompokkan keranjang per customer
        $keranjangByCustomer = $keranjangs->groupBy('keranjang_customer');

        $pesanans = [];

        foreach ($keranjangByCustomer as $customerId => $keranjangList) {

            $total_jumlah = $keranjangList->sum('keranjang_jumlah');
            $total_harga = $keranjangList->sum('keranjang_total_harga');

            // Ambil keranjang pertama sebagai referensi
            $firstKeranjang = $keranjangList->first();

            // Generate tanggal acak dari 1 Jan 2023 sampai sekarang
            $start = strtotime('2023-01-01');
            $end = time();
            $randomTimestamp = mt_rand($start, $end);
            $randomDate = date('Y-m-d', $randomTimestamp);

            $pesanans[] = [
                'pesanan_produk' => $firstKeranjang->keranjang_produk,
                'pesanan_customer' => $customerId,
                'pesanan_keranjang' => $firstKeranjang->keranjang_id,
                'pesanan_jumlah' => $total_jumlah,
                'pesanan_total_harga' => $total_harga,
                'pesanan_tanggal' => $randomDate,
                'pesanan_status' => '1', // pending
            ];
        }

        // Insert ke DB
        DB::table('lixiudiy_pesanan')->insert($pesanans);
    }
}
