<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PembayaranSeed extends Seeder
{
    public function run()
    {
        // Hapus data lama dan reset auto increment
        DB::table('lixiudiy_pembayaran')->truncate();

        // Ambil semua pesanan
        $pesanans = DB::table('lixiudiy_pesanan')->get();

        // Kelompokkan pesanan per customer
        $pesananByCustomer = $pesanans->groupBy('pesanan_customer');

        $pembayarans = [];

        foreach ($pesananByCustomer as $customerId => $pesananList) {

            // Gabungkan id pesanan jadi string 1;2;3
            $pesanan_ids = $pesananList->pluck('pesanan_id')->implode(';');

            // Total harga
            $total_harga = $pesananList->sum('pesanan_total_harga');

            // Tanggal acak dari 2023 sampai sekarang
            $start = strtotime('2023-01-01');
            $end = time();
            $randomTimestamp = mt_rand($start, $end);
            $randomDate = date('Y-m-d', $randomTimestamp);

            // Metode pembayaran random 1,2,3
            $metode = (string) mt_rand(1, 3);

            // Kurir random 1–5
            $kurir = 'Kurir ' . mt_rand(1, 5);

            $pembayarans[] = [
                'pembayaran_pesanan' => $pesanan_ids,
                'pembayaran_jumlah' => $total_harga,
                'pembayaran_tanggal' => $randomDate,
                'pembayaran_metode' => $metode,
                'pembayaran_status' => '1',
                'pembayaran_keterangan' => $kurir,
            ];
        }

        DB::table('lixiudiy_pembayaran')->insert($pembayarans);
    }
}
