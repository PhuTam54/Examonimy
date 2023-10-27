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
        Schema::create('enrollment_answers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("enrollment_id"); //->unique()
            $table->foreign("enrollment_id")->references("id")->on("enrollments");
            $table->unsignedBigInteger("question_id");
            $table->foreign("question_id")->references("id")->on("questions");
            $table->string("answers", 255)->nullable();
            $table->smallInteger("status")->default(0);
            // 0. Not answer yet 1. Correct 2. Incorrect
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollment_answers');
    }
};
