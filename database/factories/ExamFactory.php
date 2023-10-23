<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Exam>
 */
class ExamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "created_by"=>random_int(1, 20),
            "subject_id"=>random_int(1, 10),
            "exam_name"=> $this->faker->colorName,
            "exam_description"=> $this->faker->text(500),
            "duration"=> 40 * 60, // seconds
            "number_of_questions"=> 16,
            "status"=> 2,
            "exam_thumbnail"=>"storage/img/main-img/course-".random_int(1, 3).".jpg",
            "total_marks"=> 20,
            "passing_marks"=> 6.7,
        ];
    }
}
