<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\ProductReceived;
use App\Models\ProductSold;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'admin',
                'email' => 'admin@example.com',
                'password' => bcrypt('admin'),
                'role' => 'admin',
                'remember_token' => Str::random(10)
            ],
            [
                'name' => 'user',
                'email' => 'user@example.com',
                'password' => bcrypt('user'),
                'role' => 'guest',
                'remember_token' => Str::random(10)
            ]
        ]);
        //
        DB::table('animals')->insert([
            ['name' => 'cats'],
            ['name' => 'dogs'],
            ['name' => 'rodents'],
        ]);
         //
         DB::table('product_types')->insert([
            ['name' => 'feed'],
            ['name' => 'bath'],
            ['name' => 'toies'],
        ]);
        //
         DB::table('providers')->insert([
            ['name' => 'firstProvider'],
            ['name' => 'secondProvider'],
            ['name' => 'thirdProvider'],
        ]);
        //
         DB::table('brands')->insert([
            ['name' => 'firstBrand'],
            ['name' => 'secondBrand'],
            ['name' => 'thirdBrand']
        ]);
        //
        DB::table('animals_brands')->insert([
            [
                'animal_brand' => '1_1',
                'animal_id' => 1,
                'brand_id' => 1,
            ],
            [
                'animal_brand' => '2_2',
                'animal_id' => 2,
                'brand_id' => 2,
            ], 
            [
                'animal_brand' => '3_3',
                'animal_id' => 3,
                'brand_id' => 3,
            ]
        ]);
        //
        DB::table('providers_brands')->insert([
            [
                'provider_brand' => '1_1',
                'provider_id' => 1,
                'brand_id' => 1,
            ],
            [
                'provider_brand' => '2_2',
                'provider_id' => 2,
                'brand_id' => 2,
            ], 
            [
                'provider_brand' => '3_3',
                'provider_id' => 3,
                'brand_id' => 3,
            ]
        ]);
        //
        DB::table('animals_product_types')->insert([
            [
                'animal_product_type' => '1_1',
                'image_path' => fake()->imageUrl(40,40),
                'animal_id' => 1,
                'product_type_id' => 1,
            ],
            [
                'animal_product_type' => '1_2',
                'image_path' => fake()->imageUrl(40,40),
                'animal_id' => 1,
                'product_type_id' => 2,
            ],
            [
                'animal_product_type' => '1_3',
                'image_path' => fake()->imageUrl(40,40),
                'animal_id' => 1,
                'product_type_id' => 3,
            ],
            [
                'animal_product_type' => '2_1',
                'image_path' => fake()->imageUrl(40,40),
                'animal_id' => 2,
                'product_type_id' => 1,
            ],
            [
                'animal_product_type' => '2_2',
                'image_path' => fake()->imageUrl(40,40),
                'animal_id' => 2,
                'product_type_id' => 2,
            ],
            [
                'animal_product_type' => '2_3',
                'image_path' => fake()->imageUrl(40,40),
                'animal_id' => 2,
                'product_type_id' => 3,
            ],
            [
                'animal_product_type' => '3_1',
                'image_path' => fake()->imageUrl(40,40),
                'animal_id' => 3,
                'product_type_id' => 1,
            ],
            [
                'animal_product_type' => '3_2',
                'image_path' => fake()->imageUrl(40,40),
                'animal_id' => 3,
                'product_type_id' => 2,
            ],
            [
                'animal_product_type' => '3_3',
                'image_path' => fake()->imageUrl(40,40),
                'animal_id' => 3,
                'product_type_id' => 3,
            ],
        ]);

        Product::factory()
                ->count(50)
                ->has(ProductSold::factory()->count(3), 'solds')
                ->create();

        Product::factory()
                ->count(50)
                ->has(ProductReceived::factory()->count(3), 'receives')
                ->create();
    }
}
