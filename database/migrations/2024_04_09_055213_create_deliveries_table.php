<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */public function up(): void
        {
            Schema::create('deliveries', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('order_id');
                $table->string('recipient_name');
                $table->text('address');
                $table->string('phone_number');
                $table->decimal('price');
                $table->string('image')->nullable();
                $table->string('payment_status')->nullable();
                $table->unsignedBigInteger('delivery_person_id');
                $table->string('message');
                $table->integer('quantity')->nullable();
                $table->string('delivery_status');
                $table->date('delivery_date');
                $table->timestamps();
            });
        }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deliveries');
    }
};
