<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PengirimanSeed extends Seeder
{
    public function run()
    {
        // Hapus data lama dan reset auto increment
        DB::table('lixiudiy_pengiriman')->truncate();

        // Ambil semua pesanan
        $pesanans = DB::table('lixiudiy_pesanan')->get();

        // Ambil semua customer
        $customers = DB::table('lixiudiy_customer')->pluck('customer_alamat', 'customer_id');

        // Kelompokkan pesanan per customer
        $pesananByCustomer = $pesanans->groupBy('pesanan_customer');

        $pengirimans = [];
        $resiCounter = 1;

        foreach ($pesananByCustomer as $customerId => $pesananList) {

            // Gabungkan id pesanan jadi string 1;2;3
            $pesanan_ids = $pesananList->pluck('pesanan_id')->implode(';');

            // Ambil alamat customer
            $alamat = $customers[$customerId] ?? 'Alamat tidak tersedia';

            // Kurir random 1–5
            $kurir = 'Kurir ' . mt_rand(1, 5);

            // Nomor resi unik
            $nomor_resi = 'RESI' . str_pad($resiCounter, 5, '0', STR_PAD_LEFT);
            $resiCounter++;

            // Tanggal random dari 2023
            $start = strtotime('2023-01-01');
            $end = time();
            $randomTimestamp = mt_rand($start, $end);
            $randomDate = date('Y-m-d', $randomTimestamp);

            $pengirimans[] = [
                'pengiriman_pesanan' => $pesanan_ids,
                'pengiriman_alamat' => $alamat,
                'pengiriman_jasakurir' => $kurir,
                'pengiriman_nomor_resi' => $nomor_resi,
                'pengiriman_tanggal' => $randomDate,
                'pengiriman_status' => '1',
                'pengiriman_keterangan' => null,
            ];
        }

        DB::table('lixiudiy_pengiriman')->insert($pengirimans);
    }
}
