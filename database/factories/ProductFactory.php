<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'promo_id' => rand(0,10),
            'name' => fake()->name(),
            'description' => fake()->paragraph(),
            'price' => rand(1000000,9999999),
            'item_point' => rand(1,2000),
            'category' => fake()->randomElement(['food','beverages' ,'alcohol','other']),
            'image' => 'https://placehold.co/400x400?text=No+Image',
        ];
    }
}
