<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $dateStart = $this->faker->dateTimeBetween('-1 month', '+1 month', 'Asia/Jakarta');
        $dateEnd = $this->faker->dateTimeBetween($dateStart, '+1 month', 'Asia/Jakarta');
        return [
            'outlet_id' => 1,
            'type' => $this->faker->randomElement(['event','everyday','weekend','weekday']),
            'name' => $this->faker->name(),
            'description' => $this->faker->paragraph(),
            'image' => 'https://placehold.co/400x400?text=No+Image',
            'start_date' => $dateStart,
            'end_date' => $dateEnd,
            'status' => 'active'
        ];
    }
}
