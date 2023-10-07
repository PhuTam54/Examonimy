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
            "created_by"=>random_int(2, 11),
            "course_id"=>random_int(1, 10),
            "exam_name"=> $this->faker->colorName,
            "exam_description"=> $this->faker->text(500),
            "duration"=>random_int(5, 60),
            "number_of_questions"=>random_int(1, 20),
            "total_marks"=>20,
            "passing_marks"=>8,
        ];
    }
}
