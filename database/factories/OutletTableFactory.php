<?php

namespace Database\Factories;

use chillerlan\QRCode\QRCode;
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
        $qr = new QRCode();
        $table = $this->faker->randomElement(['A','B','C','D','E','F','G','H','I','J']).rand(1,10);
        return [
            'outlet_id' => 1,
            'code' => $table,
            'floor' => rand(1,2),
            'max_pax' => rand(4,9),
            'price' => rand(500000,1000000),
            'image' => 'https://placehold.co/600x400?text='.fake()->userName(),
            'qrcode' => $qr->render(
                json_encode([
                    'outlet_id' => 1,
                    'table' => $table,
                    'floor' => rand(1,2),                    
                ]))
        ];
    }
}
