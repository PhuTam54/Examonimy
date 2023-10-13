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
        Schema::create('exam_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("enrollment_id"); //->unique()
            $table->foreign("enrollment_id")->references("id")->on("enrollments");
            $table->float("score", 14, 2);
            $table->integer("time_taken")->nullable(); // seconds
            $table->string("note")->nullable(); // instructor note
            $table->smallInteger("status")->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_results');
    }
};
