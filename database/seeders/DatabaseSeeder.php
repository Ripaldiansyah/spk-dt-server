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

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);



        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            Product::create([
                'product_name' => $faker->sentence(3),
                'harga' => $faker->numberBetween(1000000, 15000000),
                'garansi' => $faker->randomElement(['Resmi', 'Distributor', 'Internasional']),
                'fitur' =>  $faker->randomElement(['Banyak', 'Cukup', 'Minim']),
                'kualitas' => $faker->randomElement(['Bagus', 'Cukup', 'Kurang']),
            ]);
        }

        $data = [
            ['harga' => '1-5 Juta', 'garansi' => 'resmi', 'fitur' => 'cukup', 'kualitas' => 'cukup', 'prediction' => 'ya', 'product_id' => $faker->numberBetween(1, 10)],
            ['harga' => '1-5 Juta', 'garansi' => 'resmi', 'fitur' => 'minim', 'kualitas' => 'kurang', 'prediction' => 'tidak', 'product_id' => $faker->numberBetween(1, 10)],
            ['harga' => '1-5 Juta', 'garansi' => 'resmi', 'fitur' => 'Banyak', 'kualitas' => 'bagus', 'prediction' => 'ya', 'product_id' => $faker->numberBetween(1, 10)],
            ['harga' => '6-10 Juta', 'garansi' => 'resmi', 'fitur' => 'Banyak', 'kualitas' => 'bagus', 'prediction' => 'tidak', 'product_id' => $faker->numberBetween(1, 10)],
            ['harga' => '11-15 Juta', 'garansi' => 'internasional', 'fitur' => 'minim', 'kualitas' => 'cukup', 'prediction' => 'tidak', 'product_id' => $faker->numberBetween(1, 10)],
            ['harga' => '11-15 Juta', 'garansi' => 'distributor', 'fitur' => 'cukup', 'kualitas' => 'kurang', 'prediction' => 'tidak', 'product_id' => $faker->numberBetween(1, 10)],
            ['harga' => '6-10 Juta', 'garansi' => 'resmi', 'fitur' => 'cukup', 'kualitas' => 'cukup', 'prediction' => 'tidak'],
            ['harga' => '11-15 Juta', 'garansi' => 'distributor', 'fitur' => 'cukup', 'kualitas' => 'cukup', 'prediction' => 'tidak', 'product_id' => $faker->numberBetween(1, 10)],
            ['harga' => '11-15 Juta', 'garansi' => 'internasional', 'fitur' => 'minim', 'kualitas' => 'cukup', 'prediction' => 'tidak', 'product_id' => $faker->numberBetween(1, 10)],
            ['harga' => '6-10 Juta', 'garansi' => 'internasional', 'fitur' => 'Banyak', 'kualitas' => 'cukup', 'prediction' => 'tidak', 'product_id' => $faker->numberBetween(1, 10)],
            ['harga' => '1-5 Juta', 'garansi' => 'resmi', 'fitur' => 'Banyak', 'kualitas' => 'bagus', 'prediction' => 'ya'],
            ['harga' => '1-5 Juta', 'garansi' => 'resmi', 'fitur' => 'cukup', 'kualitas' => 'bagus', 'prediction' => 'ya'],
            ['harga' => '6-10 Juta', 'garansi' => 'resmi', 'fitur' => 'Banyak', 'kualitas' => 'bagus', 'prediction' => 'tidak'],
            ['harga' => '6-10 Juta', 'garansi' => 'internasional', 'fitur' => 'Banyak', 'kualitas' => 'bagus', 'prediction' => 'tidak'],
            ['harga' => '1-5 Juta', 'garansi' => 'resmi', 'fitur' => 'cukup', 'kualitas' => 'cukup', 'prediction' => 'ya'],
            ['harga' => '1-5 Juta', 'garansi' => 'resmi', 'fitur' => 'minim', 'kualitas' => 'kurang', 'prediction' => 'tidak'],
            ['harga' => '1-5 Juta', 'garansi' => 'resmi', 'fitur' => 'Banyak', 'kualitas' => 'bagus', 'prediction' => 'ya'],
            ['harga' => '6-10 Juta', 'garansi' => 'resmi', 'fitur' => 'Banyak', 'kualitas' => 'bagus', 'prediction' => 'tidak'],
            ['harga' => '11-15 Juta', 'garansi' => 'internasional', 'fitur' => 'minim', 'kualitas' => 'cukup', 'prediction' => 'tidak'],
            ['harga' => '11-15 Juta', 'garansi' => 'distributor', 'fitur' => 'cukup', 'kualitas' => 'kurang', 'prediction' => 'tidak'],
            ['harga' => '6-10 Juta', 'garansi' => 'resmi', 'fitur' => 'cukup', 'kualitas' => 'cukup', 'prediction' => 'tidak'],
            ['harga' => '11-15 Juta', 'garansi' => 'distributor', 'fitur' => 'cukup', 'kualitas' => 'cukup', 'prediction' => 'tidak'],
            ['harga' => '11-15 Juta', 'garansi' => 'internasional', 'fitur' => 'minim', 'kualitas' => 'cukup', 'prediction' => 'tidak'],
            ['harga' => '6-10 Juta', 'garansi' => 'internasional', 'fitur' => 'Banyak', 'kualitas' => 'cukup', 'prediction' => 'tidak'],
            ['harga' => '1-5 Juta', 'garansi' => 'resmi', 'fitur' => 'Banyak', 'kualitas' => 'bagus', 'prediction' => 'ya'],
            ['harga' => '1-5 Juta', 'garansi' => 'resmi', 'fitur' => 'cukup', 'kualitas' => 'bagus', 'prediction' => 'ya'],
            ['harga' => '6-10 Juta', 'garansi' => 'resmi', 'fitur' => 'Banyak', 'kualitas' => 'bagus', 'prediction' => 'tidak'],
            ['harga' => '6-10 Juta', 'garansi' => 'internasional', 'fitur' => 'Banyak', 'kualitas' => 'bagus', 'prediction' => 'tidak'],
        ];

        foreach ($data as $item) {
            Train::create($item);
        }
    }
}
