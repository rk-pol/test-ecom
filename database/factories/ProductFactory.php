<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Products>
 */
class ProductFactory extends Factory
{
    // protected $faker = Faker::create();
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        
        return [
            'name' => fake()->name,
            'articul' => fake()->randomNumber(7),
            'short_description' => fake()->text(15),
            'long_description' => fake()->text(70),
            'image_path' => fake()->imageUrl($width = 245, $height = 230),
            'price' => fake()->randomFloat(2, 15, 300),
            'is_new' => fake()->boolean(60),
            'brand_id' => fake()->numberBetween(1, 3),
            'animal_id' => fake()->numberBetween(1, 3),
            'product_type_id' => fake()->numberBetween(1, 3),
        ];
    }
}
