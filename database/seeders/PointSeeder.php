<?php

namespace Database\Seeders;

use App\Models\Point;
use App\Models\User;
use Illuminate\Database\Seeder;

class PointSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // For each customer without a points record, create one
        User::role('customer')->doesntHave('point')->get()->each(function ($user) {
            Point::factory()->for($user)->create();
        });
    }
}
