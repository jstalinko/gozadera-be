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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->bigInteger('price');
            $table->string('image')->default('https://placehold.co/400x400?text=No+Image');       
            $table->enum('category', [ 'food' ,'beverages' ,'alcohol' , 'other' , 'redeemable'])->default('other');
            $table->enum('sub_category', ['starter','main_course','rice_dish','pasta_or_noodles','soup','salad','small_bites'])->default('starter')->change();
            $table->integer('stock');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
