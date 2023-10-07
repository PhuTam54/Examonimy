<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ClassRoom>
 */
class ClassRoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "class_name"=> "T".random_int(1, 23).random_int(1, 12)."A",
            "number_of_students"=>random_int(1, 50),
            "instructor_id"=>random_int(2, 11),
        ];
    }
}
