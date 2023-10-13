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
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("student_id");
            $table->foreign("student_id")->references("id")->on("users");
            $table->unsignedBigInteger("exam_id");
            $table->foreign("exam_id")->references("id")->on("exams");
            $table->unsignedSmallInteger("status")->default(0);
            // 1. Easy 2. Medium 3. Difficult ...
            $table->timestamps();
//            $table->primary(["user_id", "exam_id"]); // composite key
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
