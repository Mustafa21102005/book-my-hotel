<?php

namespace Database\Factories;

use App\Models\Hotel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Hotel>
 */
class HotelFactory extends Factory
{
    protected $model = Hotel::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $regions = ['Asia', 'Europe'];

        return [
            'name' => $this->faker->company() . ' Hotel',
            'description' => $this->faker->paragraph(),
            'region' => $this->faker->randomElement($regions),
            'country' => $this->faker->country(),
            'city' => $this->faker->city(),
            'street' => $this->faker->streetAddress(),
            'breakfast' => $this->faker->boolean(70), // 70% chance true
            'wifi' => $this->faker->boolean(90), // 90% chance true
            'pool' => $this->faker->boolean(50), // 50% chance true
            'gym' => $this->faker->boolean(50), // 50% chance true
            'pets_allowed' => $this->faker->boolean(40), // 40% chance true
            'environment' => $this->faker->boolean(50), // 50% chance true
        ];
    }

    /**
     * Configure the hotel factory.
     *
     * After creating a hotel, add a media item to the hotel from a URL.
     *
     * @return void
     */
    public function configure()
    {
        return $this->afterCreating(function (Hotel $hotel) {
            $hotel->addMediaFromUrl('https://picsum.photos/800/600')
                ->toMediaCollection('hotel-img');
        });
    }
}
