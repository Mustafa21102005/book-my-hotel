<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            RoomSeeder::class,
            PointSeeder::class,
            PromotionSeeder::class,
            DiscountSeeder::class,
            RedeemedDiscountSeeder::class,
            BookingSeeder::class,
            SustainabilityRewardSeeder::class,
            ReviewSeeder::class,
        ]);
    }
}
