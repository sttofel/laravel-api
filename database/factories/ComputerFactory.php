<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Reseller;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ComputerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'reseller_id' => Reseller::inRandomOrder()->first(),
            'customer_id' => Customer::inRandomOrder()->first(),
            'serial' => Str::random(14),
            'review' => Str::random(14),
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->date(),
        ];
    }
}
