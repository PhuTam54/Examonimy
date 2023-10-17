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
        Schema::create('answer_options', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("option_id");
            $table->foreign("option_id")->references("id")->on("question_options");
            $table->unsignedBigInteger("answer_id")->nullable();
            $table->foreign("answer_id")->references("id")->on("exam_answers");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answer_options');
    }
};
