<?php

namespace Database\Seeders;

use App\Models\SustainabilityReward;
use Illuminate\Database\Seeder;

class SustainabilityRewardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SustainabilityReward::factory()->count(5)->create();
    }
}
