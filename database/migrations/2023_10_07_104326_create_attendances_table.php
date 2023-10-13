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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->smallInteger("lesson_attendance")->nullable();
            $table->unsignedBigInteger("student_id")->nullable();
            $table->foreign("student_id")->references("id")->on("users");
            $table->unsignedBigInteger("subject_id")->nullable();
            $table->foreign("subject_id")->references("id")->on("subjects");
            $table->unsignedBigInteger("class_id")->nullable();
            $table->foreign("class_id")->references("id")->on("classes");
//            $table->primary(["user_id", "subject_id"]); // composite key
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
