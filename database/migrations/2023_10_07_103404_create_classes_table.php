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
        Schema::create('classes', function (Blueprint $table) {
            $table->id();  // unsigned bigint
            $table->string("class_name", 100)->unique(); // varchar(255)
            $table->smallInteger("number_of_students")->nullable();
            $table->unsignedBigInteger("instructor_id")->nullable();
            $table->timestamps();  // create_at , updated_at
            $table->foreign("instructor_id")->references("id")->on("users");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classes');
    }
};
