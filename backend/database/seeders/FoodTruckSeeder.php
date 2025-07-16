<?php

namespace Database\Seeders;

use App\Models\FoodTruck;
use Illuminate\Database\Seeder;

class FoodTruckSeeder extends Seeder
{
    public function run(): void
    {
        $foodTrucks = [
            // Kuala Lumpur - Traditional Malaysian
            [
                'name' => 'Pak Man\'s Char Kuey Teow',
                'food_type' => 'Char Kuey Teow',
                'location_description' => 'Jalan Alor, Bukit Bintang',
                'latitude' => 3.1478,
                'longitude' => 101.7058,
                'menu_info' => 'Authentic wok hei char kuey teow, cockles, prawns. RM8-12 per plate.',
                'news' => 'Featured in Food Network Malaysia! Queue starts at 7 PM.',
                'reported_by' => 'Ahmad Rahman',
                'last_reported_at' => now()->subHours(2),
            ],
            [
                'name' => 'Makcik Ros Nasi Lemak',
                'food_type' => 'Nasi Lemak',
                'location_description' => 'Kampung Baru Morning Market',
                'latitude' => 3.1695,
                'longitude' => 101.7008,
                'menu_info' => 'Traditional nasi lemak with sambal, anchovies, egg. RM3-15.',
                'news' => 'Weekend special: Nasi lemak with rendang daging!',
                'reported_by' => 'Siti Aminah',
                'last_reported_at' => now()->subHours(1),
            ],
            [
                'name' => 'Cendol Pak Hassan',
                'food_type' => 'Dessert',
                'location_description' => 'Central Market, KL',
                'latitude' => 3.1416,
                'longitude' => 101.6958,
                'menu_info' => 'Cendol, ABC, ais kacang, bubur chacha. RM2-8.',
                'news' => 'Using fresh coconut milk and gula melaka!',
                'reported_by' => 'Lim Wei Ming',
                'last_reported_at' => now()->subMinutes(30),
            ],
            [
                'name' => 'Roti John King',
                'food_type' => 'Roti John',
                'location_description' => 'Masjid India Street',
                'latitude' => 3.1507,
                'longitude' => 101.6951,
                'menu_info' => 'Roti john special, sardine, chicken, mutton. RM5-12.',
                'news' => 'New jumbo roti john - can feed 2 people!',
                'reported_by' => 'Kamal bin Ahmad',
                'last_reported_at' => now()->subHours(3),
            ],

            // Penang - Street Food Paradise
            [
                'name' => 'Lorong Baru Asam Laksa',
                'food_type' => 'Assam Laksa',
                'location_description' => 'Penang Road, Georgetown',
                'latitude' => 5.4164,
                'longitude' => 100.3327,
                'menu_info' => 'Authentic Penang asam laksa with tamarind broth. RM6-8.',
                'news' => 'Winner of Malaysia\'s Best Laksa 2024!',
                'reported_by' => 'Tan Ah Beng',
                'last_reported_at' => now()->subHours(2),
            ],
            [
                'name' => 'Chai Tow Kway Uncle',
                'food_type' => 'Chai Tow Kway',
                'location_description' => 'Gurney Drive Hawker Centre',
                'latitude' => 5.4370,
                'longitude' => 100.3095,
                'menu_info' => 'White and black chai tow kway, cockles. RM4-7.',
                'news' => 'Using imported white radish from Cameron Highlands!',
                'reported_by' => 'Ng Soo Hoon',
                'last_reported_at' => now()->subHours(1),
            ],
            [
                'name' => 'Penang Rojak Specialist',
                'food_type' => 'Rojak',
                'location_description' => 'Chulia Street, Georgetown',
                'latitude' => 5.4141,
                'longitude' => 100.3369,
                'menu_info' => 'Fruit rojak with special hae ko (prawn paste). RM3-6.',
                'news' => 'Secret family recipe passed down 3 generations!',
                'reported_by' => 'Lee Mei Ling',
                'last_reported_at' => now()->subMinutes(45),
            ],

            // Johor - Southern Flavors
            [
                'name' => 'JB Laksa Johor Cart',
                'food_type' => 'Laksa Johor',
                'location_description' => 'Jalan Wong Ah Fook, JB',
                'latitude' => 1.4655,
                'longitude' => 103.7578,
                'menu_info' => 'Thick laksa johor with coconut milk and fish. RM5-8.',
                'news' => 'Royal recipe approved by Johor Sultan!',
                'reported_by' => 'Ibrahim Hassan',
                'last_reported_at' => now()->subHours(4),
            ],
            [
                'name' => 'Muar Otak-Otak Express',
                'food_type' => 'Otak-Otak',
                'location_description' => 'Muar Town Centre',
                'latitude' => 2.0442,
                'longitude' => 102.5689,
                'menu_info' => 'Famous Muar otak-otak, fish cake, tau pok. RM1-3 per piece.',
                'news' => 'Fresh fish daily from Muar River!',
                'reported_by' => 'Zainab Ismail',
                'last_reported_at' => now()->subHours(2),
            ],

            // Malacca - Heritage Food
            [
                'name' => 'Nyonya Chicken Rice Ball',
                'food_type' => 'Chicken Rice Ball',
                'location_description' => 'Jonker Street, Malacca',
                'latitude' => 2.1944,
                'longitude' => 102.2439,
                'menu_info' => 'Traditional Hainanese chicken rice balls. RM8-15.',
                'news' => 'UNESCO World Heritage cooking method!',
                'reported_by' => 'Baba Tan',
                'last_reported_at' => now()->subHours(3),
            ],
            [
                'name' => 'Satay Celup Kapitang',
                'food_type' => 'Satay Celup',
                'location_description' => 'Capitol Satay, Malacca',
                'latitude' => 2.1967,
                'longitude' => 102.2463,
                'menu_info' => 'Satay celup with peanut sauce, various skewers. RM0.70-2 per stick.',
                'news' => 'Open until 2 AM - perfect for supper!',
                'reported_by' => 'Nyonya Lily',
                'last_reported_at' => now()->subHours(1),
            ],

            // Selangor - Surrounding KL
            [
                'name' => 'Bak Kut Teh Mobile',
                'food_type' => 'Bak Kut Teh',
                'location_description' => 'Klang Town Centre',
                'latitude' => 3.0369,
                'longitude' => 101.4469,
                'menu_info' => 'Klang-style bak kut teh with herbs. RM12-25 per bowl.',
                'news' => 'Original Klang recipe since 1975!',
                'reported_by' => 'Lau Ah Chong',
                'last_reported_at' => now()->subHours(2),
            ],
            [
                'name' => 'Shah Alam Roti Canai',
                'food_type' => 'Roti Canai',
                'location_description' => 'Section 14 Food Court',
                'latitude' => 3.0736,
                'longitude' => 101.5183,
                'menu_info' => 'Fluffy roti canai, roti telur, curry. RM1.50-4.',
                'news' => 'Viral TikTok tornado roti canai technique!',
                'reported_by' => 'Muthu Raman',
                'last_reported_at' => now()->subMinutes(20),
            ],

            // Perak - Ipoh Delights
            [
                'name' => 'Ipoh Hor Fun Legend',
                'food_type' => 'Hor Fun',
                'location_description' => 'Old Town, Ipoh',
                'latitude' => 4.5975,
                'longitude' => 101.0901,
                'menu_info' => 'Smooth hor fun with prawns, chicken. RM6-10.',
                'news' => 'Featured in Michelin Guide Malaysia!',
                'reported_by' => 'Cheong Fatt Tze',
                'last_reported_at' => now()->subHours(5),
            ],
            [
                'name' => 'Bean Sprout Chicken Cart',
                'food_type' => 'Tauge Ayam',
                'location_description' => 'Ipoh Railway Station',
                'latitude' => 4.5689,
                'longitude' => 101.0977,
                'menu_info' => 'Famous Ipoh bean sprout chicken with soy sauce. RM8-12.',
                'news' => 'Using limestone water for extra crunch!',
                'reported_by' => 'Lim Keat Seng',
                'last_reported_at' => now()->subHours(1),
            ],

            // Sabah - East Malaysian Flavors
            [
                'name' => 'Hinava Sabah Mobile',
                'food_type' => 'Hinava',
                'location_description' => 'Kota Kinabalu Waterfront',
                'latitude' => 5.9804,
                'longitude' => 116.0735,
                'menu_info' => 'Fresh fish hinava with lime and chili. RM12-20.',
                'news' => 'Kadazan-Dusun traditional recipe!',
                'reported_by' => 'Dayang Siti',
                'last_reported_at' => now()->subHours(6),
            ],
            [
                'name' => 'Tuaran Mee Specialist',
                'food_type' => 'Tuaran Mee',
                'location_description' => 'Tuaran Town, Sabah',
                'latitude' => 6.2014,
                'longitude' => 116.2262,
                'menu_info' => 'Sabah-style alkaline noodles with char siu. RM8-12.',
                'news' => 'Authentic Tuaran mee recipe!',
                'reported_by' => 'Ah Chong',
                'last_reported_at' => now()->subHours(4),
            ],

            // Sarawak - Borneo Cuisine
            [
                'name' => 'Sarawak Laksa King',
                'food_type' => 'Sarawak Laksa',
                'location_description' => 'Kuching Waterfront',
                'latitude' => 1.5558,
                'longitude' => 110.3471,
                'menu_info' => 'Rich coconut laksa with prawns and herbs. RM6-9.',
                'news' => 'Anthony Bourdain\'s favorite laksa!',
                'reported_by' => 'Ling Tai Fong',
                'last_reported_at' => now()->subHours(3),
            ],
            [
                'name' => 'Kolo Mee Express',
                'food_type' => 'Kolo Mee',
                'location_description' => 'Sibu Town Centre',
                'latitude' => 2.2878,
                'longitude' => 111.8889,
                'menu_info' => 'Dry kolo mee with char siu and wontons. RM4-7.',
                'news' => 'Foochow-style recipe since 1960s!',
                'reported_by' => 'Wong Ah Seng',
                'last_reported_at' => now()->subHours(2),
            ],

            // Modern Fusion & International
            [
                'name' => 'Korean BBQ Truck KL',
                'food_type' => 'Korean BBQ',
                'location_description' => 'Sunway Pyramid',
                'latitude' => 3.0738,
                'longitude' => 101.6067,
                'menu_info' => 'Korean BBQ with Malaysian twist. RM15-30.',
                'news' => 'K-pop playlist while you eat!',
                'reported_by' => 'Kim Min Jun',
                'last_reported_at' => now()->subHours(1),
            ],
            [
                'name' => 'Fusion Burger Malaysia',
                'food_type' => 'Fusion Burger',
                'location_description' => 'KLCC Park',
                'latitude' => 3.1578,
                'longitude' => 101.7123,
                'menu_info' => 'Rendang burger, satay wrap, nasi lemak burger. RM12-25.',
                'news' => 'Malaysia Day special menu available!',
                'reported_by' => 'Chef Razak',
                'last_reported_at' => now()->subMinutes(15),
            ],

            // Inactive truck for testing
            [
                'name' => 'Taco Loco',
                'food_type' => 'Mexican',
                'location_description' => 'Publika Shopping Gallery',
                'latitude' => 3.1725,
                'longitude' => 101.6738,
                'menu_info' => 'Tacos, burritos, quesadillas. RM8-18 per item.',
                'news' => 'Temporarily closed for renovation.',
                'reported_by' => 'Maria Santos',
                'last_reported_at' => now()->subHours(4),
                'is_active' => false,
            ]
        ];

        foreach ($foodTrucks as $truck) {
            FoodTruck::create($truck);
        }
    }
}
