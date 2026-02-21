<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\SustainabilityReward;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SustainabilityReward>
 */
class SustainabilityRewardFactory extends Factory
{
    protected $model = SustainabilityReward::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Pick a random user with 'customer' role
        $user = User::role('customer')->inRandomOrder()->first()
            ?? User::factory()->create()->assignRole('customer');

        // Pick a random booking for that user, or create one
        $booking = Booking::where('user_id', $user->id)->inRandomOrder()->first()
            ?? Booking::factory()->create(['user_id' => $user->id]);

        return [
            'user_id' => $user->id,
            'booking_id' => $booking->id,
            'points' => $this->faker->randomElement([5, 10, 20]),
        ];
    }
}
