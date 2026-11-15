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

        $images = [
            'https://images.unsplash.com/photo-1611892440504-42a792e24d32?w=800&h=600&fit=crop',
            'https://images.unsplash.com/photo-1616486338812-3dadae4b4ace?w=800&h=600&fit=crop',
            'https://images.unsplash.com/photo-1590490360182-c33d57733427?w=800&h=600&fit=crop',
            'https://images.unsplash.com/photo-1616594039964-ae9021a400a0?w=800&h=600&fit=crop',
            'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=800&h=600&fit=crop',
        ];

        return $this->afterCreating(function (Room $room) use ($images) {
            $room->addMediaFromUrl(fake()->randomElement($images))
                ->toMediaCollection('room-img');
        });
    }
}
