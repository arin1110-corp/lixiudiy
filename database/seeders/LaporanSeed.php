<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LaporanSeed extends Seeder
{
    public function run()
    {
        // Hapus data lama dan reset auto increment
        DB::table('lixiudiy_laporan_penjualan')->truncate();

        // Ambil semua pesanan
        $pesanans = DB::table('lixiudiy_pesanan')->get();

        $laporans = [];

        for ($i = 1; $i <= 200; $i++) {

            // Ambil tanggal acak dari 2023-01-01 sampai sekarang
            $tanggal = date('Y-m-d', strtotime('2023-01-01 +' . rand(0, 950) . ' days'));

            // Filter pesanan sebelum tanggal ini sebagai "periode"
            $pesananPeriode = $pesanans->filter(function ($p) use ($tanggal) {
                return $p->pesanan_tanggal <= $tanggal;
            });

            $totalPesanan = $pesananPeriode->count();
            $totalProduk = $pesananPeriode->pluck('pesanan_produk')->unique()->count();

            // Pastikan total produk selalu lebih besar dari total pesanan
            if ($totalProduk <= $totalPesanan) {
                $totalProduk = $totalPesanan + rand(1, 5);
            } else {
                $totalProduk += rand(0, 3);
            }

            $totalPendapatan = $pesananPeriode->sum('pesanan_total_harga');

            // Buat periode random 7–30 hari sebelum tanggal laporan
            $periodeMulai = date('Y-m-d', strtotime($tanggal . ' -' . rand(7, 30) . ' days'));
            $periodeSelesai = $tanggal;

            $laporans[] = [
                'laporan_tanggal' => $tanggal,
                'laporan_total_produk' => $totalProduk,
                'laporan_periode_mulai' => $periodeMulai,
                'laporan_periode_selesai' => $periodeSelesai,
                'laporan_total_pesanan' => $totalPesanan,
                'laporan_total_pendapatan' => $totalPendapatan,
                'laporan_keterangan' => "Laporan penjualan periode $periodeMulai s/d $periodeSelesai",
                'laporan_status' => '1',
            ];
        }

        DB::table('lixiudiy_laporan_penjualan')->insert($laporans);
    }
}
