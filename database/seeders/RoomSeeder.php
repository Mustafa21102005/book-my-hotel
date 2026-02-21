<?php

namespace Database\Seeders;

use App\Models\Hotel;
use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 5 rooms per hotel
        $hotels = Hotel::all();

        foreach ($hotels as $hotel) {
            Room::factory()->count(3)->create([
                'hotel_id' => $hotel->id,
            ]);
        }
    }
}
