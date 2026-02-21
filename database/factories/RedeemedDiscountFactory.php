<?php

namespace Database\Factories;

use App\Models\Discount;
use App\Models\RedeemedDiscount;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RedeemedDiscount>
 */
class RedeemedDiscountFactory extends Factory
{
    protected $model = RedeemedDiscount::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Pick a random user with the "customer" role
        $user = User::role('customer')->inRandomOrder()->first()
            ?? User::factory()->create()->assignRole('customer');

        // Pick a random discount
        $discount = Discount::inRandomOrder()->first()
            ?? Discount::factory()->create();

        $isUsed = $this->faker->boolean(50); // 50% chance the discount is used
        $usedAt = $isUsed ? $this->faker->dateTimeBetween('-1 month', 'now') : null;

        return [
            'user_id' => $user->id,
            'discount_id' => $discount->id,
            'is_used' => $isUsed,
            'used_at' => $usedAt,
        ];
    }
}
