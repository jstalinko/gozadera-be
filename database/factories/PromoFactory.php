<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Promo>
 */
class PromoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'description' => $this->faker->text,
            'discount_type' => $this->faker->randomElement(['percent', 'nominal']),
            'discount_value' => $this->faker->randomNumber(2),
            'image' => $this->faker->imageUrl(),
            'promo_period' => $this->faker->randomElement(['allday', 'weekday', 'weekend', 'date']),
            'promo_start' => $this->faker->date(),
            'promo_end' => $this->faker->date(),
            'promo_start_time' => '00:00:00',
            'promo_end_time' => '23:59:59',
            'status' => $this->faker->randomElement(['active', 'inactive']),
        ];
    }
}
