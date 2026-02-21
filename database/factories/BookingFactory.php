<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    protected $model = Booking::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $checkIn = $this->faker->dateTimeBetween('+1 days', '+1 month');
        $checkOut = $this->faker->dateTimeBetween($checkIn, '+1 month');

        $room = Room::inRandomOrder()->first() ?? Room::factory()->create();

        // Pick a random user with "customer" role
        $user = User::role('customer')->inRandomOrder()->first()
            ?? User::factory()->create()->assignRole('customer');

        return [
            'user_id' => $user->id,
            'room_id' => $room->id,
            'check_in' => $checkIn->format('Y-m-d'),
            'check_out' => $checkOut->format('Y-m-d'),
            'total_price' => $room->price * ((strtotime($checkOut->format('Y-m-d')) - strtotime($checkIn->format('Y-m-d'))) / 86400),
            'payment_status' => $this->faker->randomElement(['paid', 'refunded']),
            'booking_status' => $this->faker->randomElement(['active', 'cancelled', 'completed']),
        ];
    }
}
