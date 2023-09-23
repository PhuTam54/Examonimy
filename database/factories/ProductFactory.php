<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
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
            "name"=> $name,
            "slug" => Str::slug($name),
            "price"=>random_int(1, 2000),
            "thumbnail"=>"storage/img/product/product-".random_int(1, 12).".jpg",
            "description"=> $this->faker->text(500),
            "qty"=> random_int(2, 50),
            "category_id"=> random_int(1, 10),
        ];
    }
}
