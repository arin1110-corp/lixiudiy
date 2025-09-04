<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $customers = [];

        // Hapus semua data lama dan reset AUTO_INCREMENT
        DB::table('lixiudiy_customer')->truncate();

        for ($i = 1; $i <= 200; $i++) {
            $name = $faker->firstName . ' ' . $faker->lastName;
            $email = Str::slug($faker->firstName . '.' . $faker->lastName . $i) . '@gmail.com';

            $customers[] = [
                'customer_nama' => $name,
                'customer_email' => $email,
                'customer_password' => Hash::make('password123'),
                'customer_tanggaldaftar' => $faker->dateTimeBetween('-2 years', 'now')->format('Y-m-d'),
                'customer_tanggallahir' => $faker->dateTimeBetween('-60 years', '-18 years')->format('Y-m-d'),
                'customer_status' => '1',
                'customer_alamat' => $faker->address,
                'customer_telepon' => $faker->phoneNumber,
            ];
        }

        DB::table('lixiudiy_customer')->insert($customers);
    }
}
