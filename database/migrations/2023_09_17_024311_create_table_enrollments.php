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
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("exam_id");
            $table->dateTime("enrollments_date")->nullable();
            $table->smallInteger("status");
            $table->foreign("user_id")->references("id")->on("users");
            $table->foreign("exam_id")->references("id")->on("exams");
            $table->primary(["user_id", "exam_id"]); // composite key
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
