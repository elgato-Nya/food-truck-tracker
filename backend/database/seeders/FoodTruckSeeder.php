<?php

namespace Database\Seeders;

use App\Models\FoodTruck;
use Illuminate\Database\Seeder;

class FoodTruckSeeder extends Seeder
{
    public function run(): void
    {
        $foodTrucks = [
            [
                'name' => 'Hassan\'s Mee Goreng',
                'food_type' => 'Mee Goreng',
                'location_description' => 'Outside KLCC Park',
                'latitude' => 3.1578,
                'longitude' => 101.7123,
                'menu_info' => 'Famous mee goreng mamak, mee rebus, and teh tarik. RM5-8 per dish.',
                'news' => 'Now serving from 6 PM to 2 AM daily!',
                'reported_by' => 'Ahmad Rahman',
                'last_reported_at' => now()->subHours(2),
            ],
            [
                'name' => 'Coffee Bros Mobile',
                'food_type' => 'Coffee & Pastries',
                'location_description' => 'Bangsar Shopping Centre Parking',
                'latitude' => 3.1285,
                'longitude' => 101.6733,
                'menu_info' => 'Specialty coffee, croissants, sandwiches. RM8-15.',
                'news' => 'New Ethiopian beans available this week!',
                'reported_by' => 'Sarah Lim',
                'last_reported_at' => now()->subMinutes(45),
            ],
            [
                'name' => 'BBQ King',
                'food_type' => 'BBQ & Grilled',
                'location_description' => 'Jalan Alor Night Market',
                'latitude' => 3.1478,
                'longitude' => 101.7058,
                'menu_info' => 'Grilled chicken, satay, BBQ ribs. RM10-25 per serving.',
                'news' => 'Weekend special: Buy 2 get 1 free satay!',
                'reported_by' => 'David Tan',
                'last_reported_at' => now()->subHours(1),
            ],
            [
                'name' => 'Burger Bakar Station',
                'food_type' => 'Burgers',
                'location_description' => 'Near Pavilion KL',
                'latitude' => 3.1488,
                'longitude' => 101.7139,
                'menu_info' => 'Grilled burgers, fries, milkshakes. RM12-20.',
                'news' => 'New spicy rendang burger now available!',
                'reported_by' => 'Fatimah Ali',
                'last_reported_at' => now()->subHours(3),
            ],
            [
                'name' => 'Taco Loco',
                'food_type' => 'Mexican',
                'location_description' => 'Publika Shopping Gallery',
                'latitude' => 3.1725,
                'longitude' => 101.6738,
                'menu_info' => 'Tacos, burritos, quesadillas. RM8-18 per item.',
                'news' => 'Taco Tuesday: 50% off all tacos!',
                'reported_by' => 'Maria Santos',
                'last_reported_at' => now()->subHours(4),
                'is_active' => false, // This one is inactive for testing
            ]
        ];

        foreach ($foodTrucks as $truck) {
            FoodTruck::create($truck);
        }
    }
}
