<?php

namespace Database\Factories;

use App\Models\Hotel;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    protected $model = Review::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $hotel = Hotel::inRandomOrder()->first()
            ?? Hotel::factory()->create();

        // Get all customers
        $customers = User::role('customer')->pluck('id')->toArray();

        // Find customers who haven't reviewed this hotel
        $eligibleCustomers = User::role('customer')
            ->whereDoesntHave('reviews', fn($q) => $q->where('hotel_id', $hotel->id))
            ->pluck('id')
            ->toArray();

        // If all customers have reviewed this hotel → create a new one
        if (empty($eligibleCustomers)) {
            $user = User::factory()->create();
            $user->assignRole('customer');
            $userId = $user->id;
        } else {
            $userId = fake()->randomElement($eligibleCustomers);
        }

        return [
            'user_id' => $userId,
            'hotel_id' => $hotel->id,
            'rating' => fake()->numberBetween(1, 5),
            'title' => fake()->sentence(),
            'comment' => fake()->paragraph(),
        ];
    }
}
