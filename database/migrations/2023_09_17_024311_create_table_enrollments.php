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
            $table->boolean("is_paid")->default(true);
            $table->unsignedSmallInteger("status")->default(0);
            //PENDING = 0 CONFIRMED = 1 COMPLETED = 2 NOT_TAKEN = 3 CANCELED = 4 RETAKEN = 5;
            $table->smallInteger("attempt")->default(1); // The Time taking the exam
            $table->timestamps();
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
