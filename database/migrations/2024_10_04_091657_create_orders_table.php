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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('session_id',100);
            $table->string('payment',30);
            $table->integer('total_price');
            $table->string('payment_status',30);
            $table->string('invoice',100);
            $table->string('receiver_name',100);
            $table->string('receiver_tel',100);
            $table->string('receiver_address',100);
            $table->string('pickup',30);
            $table->string('pickup_status',30);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
