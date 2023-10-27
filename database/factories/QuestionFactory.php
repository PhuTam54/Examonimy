<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Question>
 */
class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "exam_id"=>random_int(1, 20),
            "question_text"=> $this->faker->text,
            "question_mark"=> random_int(1, 2),
            "type_of_question"=> random_int(1, 3),
            "difficulty"=> random_int(1, 3)
        ];
    }
}
