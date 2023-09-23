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
            $table->unsignedBigInteger("user_id")->nullable();
            $table->unsignedDecimal("grand_total", 14, 2);
            $table->string("email")->nullable();
            $table->string("full_name");
            $table->string("tel", 20);
            $table->string("address");
            $table->string("payment_method");
            $table->string("shipping_method");
            $table->string("is_paid")->default(false);
            $table->smallInteger("status");
            $table->timestamps();
            $table->foreign("user_id")->references("id")->on("users");
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
