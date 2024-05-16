<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rsvps', function (Blueprint $table) {
            $table->id();
            $table->string('invoice');
            $table->integer('member_id');
            $table->integer('outlet_id');
            $table->json('outlet_tables');
            $table->integer('subtotal');
            $table->integer('total')->default(0);
            $table->date('rsvp_date')->default(now());
            $table->enum('payment_status',['unpaid' , 'paid','canceled','expired']);
            $table->string('payment_method');
            $table->enum('status' , ['check_in' , 'check_out' , 'canceled' , 'expired' , 'issued' , 'waiting_payment'])->default('issued');
            $table->integer('pax_left')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rsvps');
    }
};
