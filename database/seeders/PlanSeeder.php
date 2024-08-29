<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    public function run()
    {
        // Fiber Optic Plans
        $fiberOptic = Plan::create([
            'name' => 'Fiber Optic',
            'type' => 'fiber_optic',
            'status' => 'active',
            'description' => 'Our fiber optic plans offer the fastest and most reliable internet experience. Perfect for streamers, gamers, and large households.'
        ]);

        $fiberOptic->planOptions()->createMany([
            [
                'name' => 'Start',
                'price' => 30,
                'description' => 'Up to 20 Mbps download speed.'
            ],
            [
                'name' => 'Standard',
                'price' => 35,
                'description' => 'Up to 30 Mbps download speed.'
            ],
            [
                'name' => 'Pro',
                'price' => 40,
                'description' => 'Up to 35 Mbps download speed.'
            ],
            [
                'name' => 'Turbo',
                'price' => 45,
                'description' => 'Up to 50 Mbps download speed.'
            ],
            [
                'name' => 'Max',
                'price' => 80,
                'description' => 'Up to 100 Mbps download speed.'
            ]
        ]);

        // Wireless Plans
        $wireless = Plan::create([
            'name' => 'Wireless',
            'type' => 'wireless',
            'status' => 'active',
            'description' => 'Our wireless plans offer a flexible and convenient internet solution. Ideal for areas where fiber optic is not available.'
        ]);

        $wireless->planOptions()->createMany([
            [
                'name' => 'Start',
                'price' => 25,
                'description' => 'Up to 6 Mbps download speed.'
            ],
            [
                'name' => 'Standard',
                'price' => 30,
                'description' => 'Up to 8 Mbps download speed.'
            ],
            [
                'name' => 'Pro',
                'price' => 35,
                'description' => 'Up to 10 Mbps download speed.'
            ],
            [
                'name' => 'Turbo',
                'price' => 40,
                'description' => 'Up to 12 Mbps download speed.'
            ],
        ]);

        // TV Plans
        $tv = Plan::create([
            'name' => 'TV',
            'type' => 'tv',
            'status' => 'active',
            'description' => 'Enjoy a wide variety of channels and entertainment options with our TV plans.'
        ]);

        $tv->planOptions()->createMany([
            [
                'name' => 'Basic',
                'price' => 11,
                'description' => 'A selection of essential channels for casual viewing.'
            ],
            [
                'name' => 'Standard',
                'price' => 17,
                'description' => 'A wider variety of channels including popular entertainment and news.'
            ],
            [
                'name' => 'Premium',
                'price' => 19,
                'description' => 'The ultimate TV experience with premium channels, HD, and on-demand options.'
            ]
        ]);

        // Corporate Plans
        $corporate = Plan::create([
            'name' => 'Corporate',
            'type' => 'corporate',
            'status' => 'active',
            'description' => 'Our corporate plans are designed to meet the needs of your business. They offer high speeds, reliable connections, and enterprise-grade features.'
        ]);

        $corporate->planOptions()->createMany([
            [
                'name' => 'Business Basic',
                'price' => 50,
                'description' => 'Suitable for small businesses with basic internet needs.'
            ],
            [
                'name' => 'Business Standard',
                'price' => 85,
                'description' => 'Ideal for medium-sized businesses requiring higher speeds and more features.'
            ],
            [
                'name' => 'Business Premium',
                'price' => 150,
                'description' => 'Designed for large businesses demanding maximum performance, reliability, and security.'
            ]
        ]);

        // Setanta
        Plan::create([
            'name' => 'Setanta Sports',
            'type' => 'tv',
            'status' => 'active',
            'setanta' => true,
            'description' => 'Enjoy premium live sports coverage with Setanta Sports.'
        ]);
    }
}
