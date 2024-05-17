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

    

        $wa_notif = [
            [
                'type' => 'order',
            'message' => 'Thanks for your order, your order id is {order_id} and total payment is {total_payment}',
            ],
            [
                'type' => 'register',
                'message' => '
Thanks for joining us, your account has been created!
Email : {email}
Username : {username}
Password : {password}
                            
*Please change your password after login

- Gozadera Indonesia',
            ],
            [
                'type' => 'reset_password',
                'message' => '
Your password has been reset!


New Password : {password}
                 
- Gozadera Indonesia'
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

        $point_settings = [
            [
                'point' => 1,
                'minimum_spend' => 100000,
            ],
            [
                'point' => 10,
                'minimum_spend' => 1000000,
            ],
            [
                'point' => 100,
                'minimum_spend' => 10000000,
            ],
            [
                'point' => 1000,
                'minimum_spend' => 100000000,
            ],
        ];

        foreach($point_settings as $setting){
            \App\Models\PointSetting::create($setting);
        }

     \App\Models\Event::factory(50)->create();

     \App\Models\Outlet::create([
        'name' => 'GOZADERA',
        'tagline' => 'Open Everyday - Sharing is Caring',
        'address' => 'Jl. Embong Kenongo No.31-39, Embong Kaliasin, Kec. Genteng, Surabaya, Jawa Timur 60271',
        'phone' => '082256978778',
        'image' => 'https://static.wixstatic.com/media/4fb28b_2a90a6e5a9ea47b6946e2185d6fecd90~mv2.jpeg/v1/fill/w_640,h_380,al_c,q_80,usm_0.66_1.00_0.01,enc_auto/4fb28b_2a90a6e5a9ea47b6946e2185d6fecd90~mv2.jpeg',
        'area_image' => 'https://placehold.co/600x400?text=Hello+World',
        'is_bar' => 1,
        'is_karoke' => 1,
        'private_room' =>  1,
        'gmaps_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d989.4447098462365!2d112.74628216962333!3d-7.265991099546306!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7fbc2fc4e7249%3A0x1ed2ba078562f007!2sGOZADERA%20INDONESIA!5e0!3m2!1sid!2sid!4v1715838675187!5m2!1sid!2sid',
        'active' => 1
        ]);


    }
}
