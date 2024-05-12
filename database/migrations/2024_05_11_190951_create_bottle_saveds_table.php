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
        Schema::create('bottle_saveds', function (Blueprint $table) {
            $table->id();
            $table->integer('member_id');
            $table->integer('outlet_id');
            $table->integer('product_id');
            $table->integer('qty');
            $table->enum('status', ['saved','taken','expired']);
            $table->timestamp('expired_at');
            $table->timestamp('taken_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bottle_saveds');
    }
};
