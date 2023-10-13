<?php

namespace Database\Factories;

use App\Models\Exam;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ExamResult>
 */
class ExamResultFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "enrollment_id"=> random_int(1, 30),
            "score"=>random_int(1, 20),
//            "date_submit",
            "time_taken"=>random_int(1, 3600),
            "status"=>random_int(1, 5),
        ];
    }
}
