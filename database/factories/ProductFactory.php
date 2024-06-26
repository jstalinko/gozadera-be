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
            'name' => fake()->name(),
            'description' => fake()->paragraph(),
            'price' => rand(1000000,9999999),
            'stock' => rand(1,2000),
            'category' => fake()->randomElement(['food','beverages' ,'alcohol','other']),
            'image' => 'https://placehold.co/400x400?text=No+Image',
            'sub_category' => fake()->randomElement(['starter','main_course','rice_dish','pasta_or_noodles','soup','salad','small_bites']),
        ];
    }
}
