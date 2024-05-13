<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Banner>
 */
class BannerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->name,
            'description' => $this->faker->text,
            'image' => 'https://placehold.co/500x500?text=' . urlencode($this->faker->name),
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'link' => $this->faker->url,
        ];
    }
}
