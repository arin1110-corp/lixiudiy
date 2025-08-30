<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class KurirSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('lixiudiy_kurir')->insert([
            [
                'kurir_nama'   => 'JNE Express',
                'kurir_notelp' => '081234567890',
                'kurir_alamat' => 'Jl. Gatot Subroto No. 10, Denpasar',
                'kurir_ongkir' => 15000,
            ],
            [
                'kurir_nama'   => 'TIKI',
                'kurir_notelp' => '081298765432',
                'kurir_alamat' => 'Jl. Imam Bonjol No. 22, Denpasar',
                'kurir_ongkir' => 12000,
            ],
            [
                'kurir_nama'   => 'POS Indonesia',
                'kurir_notelp' => '081377889900',
                'kurir_alamat' => 'Jl. Sudirman No. 5, Denpasar',
                'kurir_ongkir' => 10000,
            ],
            [
                'kurir_nama'   => 'SiCepat',
                'kurir_notelp' => '081355667788',
                'kurir_alamat' => 'Jl. Teuku Umar No. 88, Denpasar',
                'kurir_ongkir' => 13000,
            ],
            [
                'kurir_nama'   => 'J&T Express',
                'kurir_notelp' => '081366778899',
                'kurir_alamat' => 'Jl. Diponegoro No. 45, Denpasar',
                'kurir_ongkir' => 14000,
            ],
        ]);
    }
}
