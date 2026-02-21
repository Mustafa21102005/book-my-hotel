<?php

namespace Database\Factories;

use App\Models\Discount;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Discount>
 */
class DiscountFactory extends Factory
{
    protected $model = Discount::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => $this->faker->unique()->regexify('[A-Z]{6}'),
            'points_required' => $this->faker->randomElement([10, 20, 50, 100]),
            'discount_percent' => $this->faker->randomElement([5, 10, 15, 20]),
            'expires_at' => $this->faker->dateTimeBetween('now', '+6 months'),
        ];
    }
}
