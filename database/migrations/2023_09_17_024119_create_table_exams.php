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
            $table->unsignedBigInteger("created_by")->nullable();
            $table->unsignedBigInteger("course_id")->nullable();
            $table->string("exam_name");
            $table->text("exam_description");
            $table->string("exam_thumbnail")->nullable();
            $table->dateTime("start_date")->nullable();
            $table->dateTime("end_date")->nullable();
            $table->float("duration"); // Thoi gian lam bai
            $table->smallInteger("number_of_questions");
            $table->unsignedFloat("total_marks", 14, 2);
            $table->unsignedFloat("passing_marks", 14, 2);
            $table->unsignedSmallInteger("status")->default(0);
            // 0. Not start yet 1. Starting 2. Completed
            $table->smallInteger("type_of_exam")->default(1); // 1. Trac Nghiem 2. Tu Luan
            $table->timestamps();
            $table->foreign("created_by")->references("id")->on("users");
            $table->foreign("course_id")->references("id")->on("courses");
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
