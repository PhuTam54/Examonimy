<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Classes>
 */
class ClassesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "class_name"=> "T".random_int(23, 99).random_int(1, 12)."A",
            "number_of_students"=>random_int(1, 20),
            "instructor_id"=>random_int(1, 20),
        ];
    }
}
