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
        Schema::create('wa_notifs', function (Blueprint $table) {
            $table->id();
            $table->enum('type',['order','register' , 'reset_password' , 'welcome','promo', 'custom' , 'payment']);
            $table->text('message');
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wa_notifs');
    }
};
