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
        \App\Models\Banner::factory(6)->create();
       \App\Models\RedeemPoint::factory(10)->create();
        \App\Models\User::factory()->create([
            'name' => 'Administrator',
            'email' => 'admin@gozadera.id',
            'password' => '$2y$12$VNw6tSfXdya51O0dm5rAw.6oaHQP3.99cEjUplCUGf8DHVqty2Uou',
        ]);
         \App\Models\Member::factory(100)->create();
        \App\Models\Product::factory(100)->create();
        \App\Models\OutletTable::factory(20)->create();

        \App\Models\Promo::factory(10)->create();

        $wa_notif = [
            [
                'type' => 'order',
            'message' => 'Thanks for your order, your order id is {order_id} and total payment is {total_payment}',
            ],
            [
                'type' => 'register',
                'message' => 'Thanks for joining us, your account has been created!\n\n Email : {email}\n Username : {username}\n Password : {password}\n Please change your password after login',
            ],
            [
                'type' => 'reset_password',
                'message' => 'Your password has been reset, this is your new password\n\n Password : {password}\n Please change your password after login'
            ],
            [
                'type' => 'welcome',
                'message' => 'Welcome to our app, {name}! We are happy to have you as our member',
            ],
            [
                'type' => 'promo',
                'message' => 'We have a new promo for you, {name}! Get {promo} for only {price}! Grab it fast!',
            ],
            [
                'type' => 'custom',
                'message' => 'Halo {name}, {other}',
            ],
            [
                'type' => 'payment',
                'message' => 'Thanks for your payment, your payment id is {payment_id} and total payment is {total_payment}'
            ]
        ];

        foreach($wa_notif as $notif){
            \App\Models\WaNotif::create($notif);
        }

        $member_levels = [
            [
                'name' => 'Basic',
                'minumum_spend' => 0,
            ],
            [
                'name' => 'Silver',
                'minumum_spend' => 1000000,
            ],
            [
                'name' => 'Gold',
                'minumum_spend' => 5000000,
            ],
            [
                'name' => 'VIP',
                'minumum_spend' => 10000000,
            ],
            [
                'name' => 'VVIP',
                'minumum_spend' => 50000000,
            ],
        ];

        foreach($member_levels as $level){
            \App\Models\MemberLevel::create($level);
        }

    }
}
