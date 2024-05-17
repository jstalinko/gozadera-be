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
        Schema::create('outlet_tables', function (Blueprint $table) {
            $table->id();
            $table->integer('outlet_id');
            $table->string('code');
            $table->string('floor')->default(1);
            $table->integer('max_pax')->default(4);
            $table->integer('price');
            $table->string('image');
            $table->longText('qrcode');
            $table->json('booked_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outlet_tables');
    }
};
