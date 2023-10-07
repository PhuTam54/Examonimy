<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->unique()->country;
        return [
            "course_name"=> $name,
//            "slug"=> Str::slug($name),
            "course_description"=> $this->faker->unique()->city,
            "course_year"=> random_int(0, 2),
        ];
    }
}
