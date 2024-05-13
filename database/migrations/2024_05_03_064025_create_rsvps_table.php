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
            $table->integer('member_id');
            $table->integer('outlet_id');
            $table->integer('pax');
            $table->integer('table_id');
            $table->integer('table_price');
            $table->integer('subtotal')->comment('total harga table + items');
            $table->enum('payment_status',['unpaid' , 'paid','canceled','expired']);
            $table->enum('status' , ['check_in' , 'check_out' , 'canceled' , 'expired' , 'issued'])->default('issued');
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
