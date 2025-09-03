<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('lixiudiy_admin')->insert([
            'admin_nama' => 'Admin',
            'admin_email' => 'admin@admin.com',
            'admin_password' => Hash::make('admin123'),
            'admin_tanggaldibuat' => now(),
            'admin_status' => '1',
        ]);
    }
}
