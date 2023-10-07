<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subject>
 */
class SubjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->unique()->colorName;
        return [
            "subject_name"=> $name,
//            "slug" => Str::slug($name),
            "thumbnail"=>"storage/img/main-img/cat-".random_int(1, 4).".jpg",
            "subject_description"=> $this->faker->text(500),
            "lesson"=> random_int(0, 50),
            "course_id"=> random_int(1, 10),
        ];
    }
}
