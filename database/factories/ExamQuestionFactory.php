<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ExamQuestion>
 */
class ExamQuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "exam_question_name",
            "exam_question_description",
            "duration"=> 40 * 60, // seconds
            "number_of_questions"=> 16,
            "total_marks"=> 20,
            "passing_marks"=> 6.7,
            "status",
            "exam_id"
        ];
    }
}
