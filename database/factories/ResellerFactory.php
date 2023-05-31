<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Customer;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ResellerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::inRandomOrder()->first(),
            'company_name' => $this->faker->name(),
            'document' => Str::random(14),
        ];
    }
}
