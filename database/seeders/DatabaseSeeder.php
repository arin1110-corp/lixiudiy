<?php

namespace Database\Seeders;

use App\Models\User;
use Google\Service\CloudControlsPartnerService\Customer;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            AdminSeeder::class,
            KeranjangSeed::class,
            PengirimanSeed::class,
            PesananSeed::class,
            KurirSeeder::class,
            CustomerSeeder::class,
            LaporanSeed::class,
            PembayaranSeed::class,
            // tambahkan semua seeder lain di sini
        ]);
    }
}
