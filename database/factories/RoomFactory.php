<?php

namespace Database\Factories;

use App\Models\Hotel;
use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    protected $model = Room::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $hotel = Hotel::inRandomOrder()->first() ?? Hotel::factory()->create();

        $roomTypes = ['standard', 'deluxe', 'suite'];

        return [
            'hotel_id' => $hotel->id,
            'name' => $this->faker->word() . ' Room',
            'type' => $this->faker->randomElement($roomTypes),
            'price' => $this->faker->numberBetween(50, 1000),
            'capacity' => $this->faker->numberBetween(1, 6)
        ];
    }

    /**
     * Configure the room factory.
     *
     * After creating a room, add a media item to the room from a URL.
     *
     * @return void
     */
    public function configure()
    {
        return $this->afterCreating(function (Room $room) {
            $room->addMediaFromUrl('https://picsum.photos/600/400')
                ->toMediaCollection('room-img');
        });
    }
}
