<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Voucher>
 */
class VoucherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => fake()->unique()->regexify('[A-Z0-9]{10}'),
            'discount_value' => fake()->randomFloat(2, 1000, 50000),
            'description' => fake()->optional()->text(),
            'quantity' => fake()->numberBetween(10, 100),
            'used_times' => fake()->numberBetween(0, 20),
            'total_min' => fake()->randomFloat(2, 0, 100000),
            'total_max' => fake()->optional()->randomFloat(2, 100000, 1000000),
            'start_day' => fake()->optional()->dateTime(),
            'end_day' => fake()->optional()->dateTime(),
            'is_active' => fake()->randomElement([0, 1]),
        ];
    }
}
