<?php

namespace Database\Seeders;

use App\Models\RedeemedDiscount;
use Illuminate\Database\Seeder;

class RedeemedDiscountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RedeemedDiscount::factory()->count(5)->create();
    }
}
