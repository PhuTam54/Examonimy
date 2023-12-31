<?php

namespace Database\Factories;

use Carbon\Carbon;
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
            "subject_id"=>random_int(1, 5),
            "exam_question_id"=>random_int(1, 4),
            "exam_name"=> $this->faker->colorName,
            "exam_description"=> $this->faker->text(500),
            "start_date" => Carbon::now(),
            "end_date" => Carbon::now()->addDay(),
            "retaken_fee" => random_int(1, 100),
            "status"=> 2,
            "exam_thumbnail"=>"storage/img/main-img/course-".random_int(1, 3).".jpg",
        ];
    }
}
