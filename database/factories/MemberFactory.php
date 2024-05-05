<?php

namespace Database\Factories;

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
        /**
         *    $table->string('username');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone');
            $table->text('address');
            $table->integer('point');
            $table->enum('status' , ['active' , 'inactive' , 'banned']);
            $table->string('image')->default('https://ui-avatars.com/api/?name=Avatar');
         */
        return [
            'username' => fake()->userName(),
            'email' => fake()->userName().'@gmail.com',
            'password' => bcrypt('password123'),
            'phone' => '0878'.rand(111111111,999999999),
            'address' => fake()->address(),
            'point' => rand(0,100000),
            'status' => fake()->randomElement(['active' , 'inactive' , 'banned']),
            'image' => 'https://ui-avatars.com/api/?name='.fake()->userName()
        ];
    }
}
