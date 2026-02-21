<?php

namespace Database\Seeders;

use App\Models\Hotel;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hotels = Hotel::all();
        $customers = User::role('customer')->get();

        foreach ($hotels as $hotel) {

            // Each hotel gets 5 reviews (adjust if needed)
            $reviewsToCreate = 5;

            // Shuffle customers to randomize selection
            $availableCustomers = $customers->shuffle();

            for ($i = 0; $i < $reviewsToCreate; $i++) {

                // If there aren't enough customers, create new ones
                if (!isset($availableCustomers[$i])) {
                    $newCustomer = User::factory()->create();
                    $newCustomer->assignRole('customer');
                    $availableCustomers[] = $newCustomer;
                }

                Review::factory()->create([
                    'user_id' => $availableCustomers[$i]->id,
                    'hotel_id' => $hotel->id,
                ]);
            }
        }
    }
}
