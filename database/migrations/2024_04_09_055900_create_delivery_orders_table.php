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
        Schema::create('delivery_orders', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->unsignedBigInteger('customer_id');
            $table->string('customer_address');
            $table->string('cake_image')->nullable();
            $table->string('order_number')->unique();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->string('payment_type')->nullable();
            $table->string('status')->default('pending')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_orders');
    }
};
