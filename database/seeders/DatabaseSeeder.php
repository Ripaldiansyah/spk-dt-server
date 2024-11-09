<?php

namespace Database\Seeders;

use App\Models\Criteria;
use App\Models\Product;
use App\Models\Train;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create(
            [
                'name' => 'Ripal',
                'email' => 'admin@rh.com',

            ],
        );



        $faker = Faker::create();
        $dataProduct = [
            [
                'product_name' => 'ASUS TUF Gaming AX4200',
                'harga' => 2239000,
                'garansi' => 'Resmi',
                'fitur' => 'Cukup',
                'kualitas' => 'Cukup',
                'photo' => "https://images.tokopedia.net/img/cache/900/VqbcmM/2024/7/9/61586557-25d0-4054-b75a-0f78526fb2c6.jpg",
            ],
            [
                'product_name' => 'Ruijie RG-EW3200GX PRO',
                'harga' => 1469000,
                'garansi' => 'Resmi',
                'fitur' => 'Minim',
                'kualitas' => 'Kurang',
                'photo' => "https://images.tokopedia.net/img/cache/900/VqbcmM/2023/12/30/3abeabd1-cb2c-4771-94cc-524b13b04597.jpg",
            ],
            [
                'product_name' => 'TP-Link Archer MR400 4G',
                'harga' => 4809000,
                'garansi' => 'Resmi',
                'fitur' => 'Banyak',
                'kualitas' => 'Bagus',
                'photo' => "https://images.tokopedia.net/img/cache/900/VqbcmM/2024/6/18/8d878fac-e13a-443c-82fb-6065f62e78c9.png",
            ],
            [
                'product_name' => 'ASUS ROG Rapture GT-AX1100',
                'harga' => 8700000,
                'garansi' => 'Resmi',
                'fitur' => 'Banyak',
                'kualitas' => 'Bagus',
                'photo' => "https://images.tokopedia.net/img/cache/900/VqbcmM/2024/7/9/2845bf1f-0e37-456e-a13e-56adf028095c.jpg",
            ]
        ];

        foreach ($dataProduct as $item) {
            Product::create($item);
        }


        $data = [

            ['harga' => '1-5 Juta', 'garansi' => 'Resmi', 'fitur' => 'Cukup', 'kualitas' => 'Cukup', 'prediction' => 'Ya'],
            ['harga' => '1-5 Juta', 'garansi' => 'Resmi', 'fitur' => 'Minim', 'kualitas' => 'Kurang', 'prediction' => 'Tidak'],
            ['harga' => '1-5 Juta', 'garansi' => 'Resmi', 'fitur' => 'Banyak', 'kualitas' => 'Bagus', 'prediction' => 'Ya'],
            ['harga' => '6-10 Juta', 'garansi' => 'Resmi', 'fitur' => 'Banyak', 'kualitas' => 'Bagus', 'prediction' => 'Tidak'],
            ['harga' => '11-15 Juta', 'garansi' => 'Internasional', 'fitur' => 'Minim', 'kualitas' => 'Cukup', 'prediction' => 'Tidak'],
            ['harga' => '11-15 Juta', 'garansi' => 'Distributor', 'fitur' => 'Cukup', 'kualitas' => 'Kurang', 'prediction' => 'Tidak'],
            ['harga' => '6-10 Juta', 'garansi' => 'Resmi', 'fitur' => 'Cukup', 'kualitas' => 'Cukup', 'prediction' => 'Tidak'],
            ['harga' => '11-15 Juta', 'garansi' => 'Distributor', 'fitur' => 'Cukup', 'kualitas' => 'Cukup', 'prediction' => 'Tidak'],
            ['harga' => '11-15 Juta', 'garansi' => 'Internasional', 'fitur' => 'Minim', 'kualitas' => 'Cukup', 'prediction' => 'Tidak'],
            ['harga' => '6-10 Juta', 'garansi' => 'Internasional', 'fitur' => 'Banyak', 'kualitas' => 'Cukup', 'prediction' => 'Tidak'],
            ['harga' => '1-5 Juta', 'garansi' => 'Resmi', 'fitur' => 'Banyak', 'kualitas' => 'Bagus', 'prediction' => 'Ya'],
            ['harga' => '1-5 Juta', 'garansi' => 'Resmi', 'fitur' => 'Cukup', 'kualitas' => 'Bagus', 'prediction' => 'Ya'],
            ['harga' => '6-10 Juta', 'garansi' => 'Resmi', 'fitur' => 'Banyak', 'kualitas' => 'Bagus', 'prediction' => 'Tidak'],
            ['harga' => '6-10 Juta', 'garansi' => 'Internasional', 'fitur' => 'Banyak', 'kualitas' => 'Bagus', 'prediction' => 'Tidak']


        ];

        foreach ($data as $item) {
            Train::create($item);
        }
    }
}
