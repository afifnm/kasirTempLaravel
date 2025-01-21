<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 10) as $index) {
            DB::table('products')->insert([
                'name' => $faker->word,
                'barcode' => $faker->unique()->ean13, // Generate barcode 13 digit
                'price' => $faker->randomFloat(2, 10000, 500000), // Harga antara 10.000 - 500.000
                'stock' => $faker->numberBetween(1, 100), // Stok antara 1 - 100
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
