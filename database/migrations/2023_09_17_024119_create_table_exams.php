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
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->string("exam_name");
            $table->text("exam_description");
            $table->string("exam_thumbnail")->nullable();
            $table->dateTime("start_date")->nullable();
            $table->dateTime("end_date")->nullable();
            $table->unsignedFloat("retaken_fee")->default(0);
            $table->smallInteger("type_of_exam")->default(1);
            // 1. MultipleChoice 2. Essay 3. Listening - English - Toeic
            $table->unsignedBigInteger("created_by")->nullable();
            $table->unsignedBigInteger("subject_id")->nullable();
            $table->unsignedBigInteger("exam_question_id")->nullable();
            $table->unsignedSmallInteger("status")->default(0);
            // 0. Not start yet 1. Starting 2. Completed
            $table->timestamps();
            $table->foreign("created_by")->references("id")->on("users");
            $table->foreign("subject_id")->references("id")->on("subjects");
            $table->foreign("exam_question_id")->references("id")->on("exam_questions");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};
