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
            $table->string("exam_question_name");
            $table->text("exam_question_description");
            $table->unsignedFloat("total_marks", 14, 2);
            $table->unsignedFloat("passing_marks", 14, 2);
            $table->integer("duration"); // Thoi gian lam bai (seconds)
            $table->smallInteger("number_of_questions");
            $table->unsignedSmallInteger("status")->default(0);
            // 0. Pending 1. Confirmed 2. Canceled
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
