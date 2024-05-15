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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->integer('outlet_id');
            $table->enum('type',['event' , 'everyday','weekend','weekday']);
            $table->string('name');
            $table->text('description');
            $table->string('image')->default('https://placehold.co/400x400?text=No+Image');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->enum('status' ,['active' , 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
