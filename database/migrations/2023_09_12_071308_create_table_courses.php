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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();  // unsigned bigint
            $table->string("course_name", 100)->unique(); // varchar(255)
            $table->text("course_description")->nullable();
            $table->string("course_thumbnail")->nullable();
            $table->unsignedFloat("course_year", 14, 2)->nullable();
            $table->timestamps();  // create_at , updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
