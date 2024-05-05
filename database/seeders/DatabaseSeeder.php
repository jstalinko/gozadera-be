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

        // \App\Models\User::factory()->create([
        //     'name' => 'Administrator',
        //     'email' => 'admin@gozadera.id',
        //     'password' => '$2y$12$VNw6tSfXdya51O0dm5rAw.6oaHQP3.99cEjUplCUGf8DHVqty2Uou',
        // ]);
        //  \App\Models\Member::factory(100)->create();
        //  \App\Models\Product::factory(100)->create();
        // \App\Models\OutletTable::factory(20)->create();

        // \App\Models\Promo::factory(10)->create();

        $wa_notif = [
            [
                'type' => 'order',
            'message' => 'Terima kasih telah memesan di Gozadera, pesanan anda sedang kami proses\n  ORDER ID : {order_id}',
            ],
            [
                'type' => 'register',
                'message' => 'Terima kasih telah mendaftar di Gozadera, ini adalah link verifikasi anda\n {register_link} \n klik untuk mengaktifkan akun anda',
            ],
            [
                'type' => 'reset_password',
                'message' => 'Klik link berikut untuk mereset password anda\n {reset_link} \n Jika anda tidak merasa melakukan permintaan ini, abaikan pesan ini',
            ],
            [
                'type' => 'welcome',
                'message' => 'Selamat datang di Gozadera, nikmati promo kami dengan kode {promo_code} dan dapatkan diskon sebesar {promo_value}%',
            ],
            [
                'type' => 'promo',
                'message' => 'Promo {promo_name} telah dimulai, dapatkan diskon sebesar {promo_value}% selama {promo_period} hari',
            ],
            [
                'type' => 'custom',
                'message' => 'Halo {name}, {other}',
            ],
            [
                'type' => 'payment',
                'message' => 'Terima kasih telah melakukan pembayaran, pembayaran anda telah kami terima\n PAYMENT ID : {payment_id}',
            ]
        ];

        foreach($wa_notif as $notif){
            \App\Models\WaNotif::create($notif);
        }
    }
}
