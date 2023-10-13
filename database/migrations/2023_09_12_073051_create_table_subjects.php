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
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string("subject_name")->unique();
//            $table->string("slug")->unique();
            $table->string("subject_thumbnail")->nullable();
            $table->text("subject_description")->nullable();
            $table->unsignedSmallInteger("lesson")->default(0);
            $table->unsignedBigInteger("course_id");
            $table->timestamps();
            $table->foreign("course_id")->references("id")->on("courses");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};
