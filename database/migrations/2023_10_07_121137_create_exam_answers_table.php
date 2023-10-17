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
        Schema::create('exam_answers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("enrollment_id"); //->unique()
            $table->foreign("enrollment_id")->references("id")->on("enrollments");
            $table->unsignedBigInteger("question_id")->nullable();
            $table->foreign("question_id")->references("id")->on("exam_questions");
            $table->string("answer_text")->nullable();
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
        Schema::dropIfExists('exam_answers');
    }
};
