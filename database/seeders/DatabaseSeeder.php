<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Administrator',
            'email' => 'admin@gozadera.id',
            'password' => '$2y$12$VNw6tSfXdya51O0dm5rAw.6oaHQP3.99cEjUplCUGf8DHVqty2Uou',
        ]);
         \App\Models\Member::factory(100)->create();
         \App\Models\Product::factory(100)->create();
        \App\Models\OutletTable::factory(20)->create();

        \App\Models\Promo::factory(10)->create();
    }
}
