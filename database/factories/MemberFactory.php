<?php

namespace Database\Factories;

use chillerlan\QRCode\QRCode;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Member>
 */
class MemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $qrcode = new QRCode();
        
        $username = fake()->userName();
        $email = fake()->userName().'@gmail.com';
        return [
            'username' => $username,
            'email' => $email,
            'password' => bcrypt('password123'),
            'phone' => '0878'.rand(111111111,999999999),
            'address' => fake()->address(),
            'point' => rand(0,100000),
            'status' => fake()->randomElement(['active' , 'inactive' , 'banned']),
            'image' => 'https://ui-avatars.com/api/?name='.fake()->userName(),
            'qrcode' => $qrcode->render(base64_encode($username.'|'.$email)),
        ];
    }
}
