<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "user_id"=>random_int(1, 10),
            "grand_total"=>0,
            "full_name"=> $this->faker->name,
            "tel"=>$this->faker->phoneNumber,
            "address"=>$this->faker->address,
            "payment_method"=>"COD",
            "shipping_method"=>"Express",
            "is_paid"=>false,
            "status"=>random_int(0, 3)
        ];
    }
}
