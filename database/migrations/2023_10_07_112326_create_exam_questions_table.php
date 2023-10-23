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
        Schema::create('exam_questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger("question_no");
            $table->text("question_text")->unique();
            $table->unsignedBigInteger("exam_id");
            $table->foreign("exam_id")->references("id")->on("exams");
            $table->unsignedFloat("question_mark", 14, 2);
            $table->unsignedSmallInteger("difficulty")->default(1);
            // 1. Easy 2. Medium 3. Difficult
            $table->unsignedSmallInteger("type_of_question")->default(1);
            // 1. Multiple choice 2. Choice 3. Fill in the blank
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_questions');
    }
};
