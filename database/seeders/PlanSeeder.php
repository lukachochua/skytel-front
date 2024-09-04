<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlanSeeder extends Seeder
{
    /**
     * Seed the application's database with plans.
     *
     * @return void
     */
    public function run()
    {
        DB::table('plans')->insert([
            [
                'name' => 'Fiber Optic Basic',
                'description' => 'Basic Fiber Optic Plan with 100 Mbps speed.',
                'price' => 29.99,
                'type' => 'Fiber Optic',
            ],
            [
                'name' => 'Fiber Optic Premium',
                'description' => 'Premium Fiber Optic Plan with 500 Mbps speed.',
                'price' => 49.99,
                'type' => 'Fiber Optic',
            ],
            [
                'name' => 'WiFi/Radio Basic',
                'description' => 'Basic WiFi/Radio Plan with 50 Mbps speed.',
                'price' => 19.99,
                'type' => 'WiFi/Radio',
            ],
            [
                'name' => 'WiFi/Radio Advanced',
                'description' => 'Advanced WiFi/Radio Plan with 200 Mbps speed.',
                'price' => 39.99,
                'type' => 'WiFi/Radio',
            ],
            [
                'name' => 'Corporate Standard',
                'description' => 'Corporate Plan with 1 Gbps speed and additional features.',
                'price' => 99.99,
                'type' => 'Corporate',
            ],
        ]);
    }
}
