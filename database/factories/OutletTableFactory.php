<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OutletTable>
 */
class OutletTableFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'outlet_id' => 1,
            'code' => fake()->randomElement(['A','B','C']).rand(1,10),
            'floor' => 2,
            'max_pax' => rand(4,9),
            'price' => rand(500000,1000000),
            'image' => 'https://placehold.co/600x400?text='.fake()->userName()
        ];
    }
}
