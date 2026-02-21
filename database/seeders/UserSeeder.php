<?php

namespace Database\Seeders;

use App\Models\Hotel;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles
        $roles = ['admin', 'hotel_manager', 'customer'];
        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName]);
        }

        // Create admin user
        $adminUser = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
        ]);
        $adminUser->assignRole('admin');

        // Define accurate hotel info
        $hotelsData = [
            [
                'name' => 'The Marriott',
                'description' => 'Luxury hotel with modern amenities, spacious rooms, and exceptional service.',
                'region' => 'Asia',
                'country' => 'Japan',
                'city' => 'Tokyo',
                'street' => '1-1 Marunouchi',
            ],
            [
                'name' => 'The Hilton',
                'description' => 'Elegant hotel with comfortable rooms, fine dining, and a central location.',
                'region' => 'Europe',
                'country' => 'United Kingdom',
                'city' => 'London',
                'street' => '22 Park Lane',
            ],
            [
                'name' => 'The Hyatt',
                'description' => 'Upscale hotel with rooftop pool, gym facilities, and business-friendly services.',
                'region' => 'Asia',
                'country' => 'Singapore',
                'city' => 'Singapore',
                'street' => '5 Raffles Avenue',
            ],
            [
                'name' => 'The Four Seasons',
                'description' => 'World-renowned hotel with luxurious rooms, exceptional service, and fine dining.',
                'region' => 'Europe',
                'country' => 'France',
                'city' => 'Paris',
                'street' => '99 Avenue des Champs-Élysées',
            ],
        ];

        // Create hotel managers with hotels
        User::factory()
            ->count(4)
            ->create()
            ->each(function ($user, $index) use ($hotelsData) {
                $user->assignRole('hotel_manager');

                $hotelInfo = $hotelsData[$index];

                Hotel::factory()->create([
                    'manager_id' => $user->id,
                    'name' => $hotelInfo['name'],
                    'description' => $hotelInfo['description'],
                    'region' => $hotelInfo['region'],
                    'country' => $hotelInfo['country'],
                    'city' => $hotelInfo['city'],
                    'street' => $hotelInfo['street'],
                ]);
            });

        // Create customer users
        User::factory()
            ->count(6)
            ->create()
            ->each(function ($user) {
                $user->assignRole('customer');
            });
    }
}
