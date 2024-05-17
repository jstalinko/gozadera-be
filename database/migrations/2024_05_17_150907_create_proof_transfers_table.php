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
        Schema::create('proof_transfers', function (Blueprint $table) {
            $table->id();
            $table->integer('member_id');
            $table->integer('rsvp_id')->nullable();
            $table->integer('order_id')->nullable();
            $table->string('image');
            $table->string('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proof_transfers');
    }
};
