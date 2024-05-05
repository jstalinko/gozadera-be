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
        Schema::create('promos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->enum('discount_type' , ['percent' , 'nominal']);
            $table->integer('discount_value')->default(0);
            $table->string('image');
            $table->enum('promo_period' , ['allday' , 'weekday' , 'weekend' , 'date'])->default('allday');
            $table->date('promo_start');
            $table->date('promo_end');
            $table->string('promo_start_time')->nullable();
            $table->string('promo_end_time')->nullable();
            $table->enum('status' , ['active' , 'inactive'])->default('active'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promos');
    }
};
