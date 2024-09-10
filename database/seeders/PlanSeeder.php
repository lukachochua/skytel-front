<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plan;
use App\Models\TvPlan;
use App\Models\PlanType;
use App\Models\Package;

class PlanSeeder extends Seeder
{
    public function run()
    {
        // Ensure PlanTypes exist or create them if they don't
        $internetType = PlanType::firstOrCreate(
            ['name' => 'ინტერნეტი', 'name->en' => 'Internet']
        );

        $fiberOpticType = PlanType::firstOrCreate(
            ['name' => 'ოპტიკურ-ბოჭკოვანი', 'name->en' => 'Fiber Optic']
        );

        $wifiRadioType = PlanType::firstOrCreate(
            ['name' => 'რადიო', 'name->en' => 'WiFi/Radio']
        );

        $corporateType = PlanType::firstOrCreate(
            ['name' => 'კორპორატიული', 'name->en' => 'Corporate']
        );

        // Define TV Plan Types
        $tvPlanTypes = [
            'Basic',
            'Pro',
            'Ultra'
        ];

        // Define plans data
        $plans = [
            [
                'name' => 'Basic Internet',
                'description' => 'A basic internet plan suitable for home users.',
                'price' => 19.99,
                'plan_type_id' => $internetType->id,
            ],
            [
                'name' => 'Fiber Optic Premium',
                'description' => 'High-speed fiber optic internet with additional TV channels.',
                'price' => 99.99,
                'plan_type_id' => $fiberOpticType->id,
                'tv_plan' => [
                    'name' => 'Premium TV',
                    'description' => 'Includes over 200 channels with HD quality.',
                    'price' => 29.99,
                    'packages' => [
                        ['name' => 'Sports Package', 'price' => 9.99],
                        ['name' => 'Movies Package', 'price' => 12.99],
                    ],
                ],
            ],
            [
                'name' => 'Corporate Internet',
                'description' => 'High-speed internet plan for corporate use.',
                'price' => 199.99,
                'plan_type_id' => $corporateType->id,
            ],
            [
                'name' => 'WiFi/Radio Basic',
                'description' => 'Basic WiFi/Radio plan for personal use.',
                'price' => 49.99,
                'plan_type_id' => $wifiRadioType->id,
            ],
            // Additional plans with TV plans
            [
                'name' => 'Fiber Optic Ultra',
                'description' => 'Ultra-fast fiber optic internet with extensive TV channels.',
                'price' => 149.99,
                'plan_type_id' => $fiberOpticType->id,
                'tv_plan' => [
                    'name' => 'Ultra TV',
                    'description' => 'Over 500 channels with exclusive content.',
                    'price' => 49.99,
                    'packages' => [
                        ['name' => 'Sports Package', 'price' => 14.99],
                        ['name' => 'Movies Package', 'price' => 19.99],
                        ['name' => 'News Package', 'price' => 7.99],
                        ['name' => 'Documentary Package', 'price' => 9.99],
                    ],
                ],
            ],
        ];

        // Iterate over each plan and create them in the database if they don't exist
        foreach ($plans as $planData) {
            $tvPlanData = $planData['tv_plan'] ?? null;
            unset($planData['tv_plan']);

            // Create or update the plan to avoid duplication
            $plan = Plan::firstOrCreate(
                ['name' => $planData['name']],
                $planData
            );

            // If the plan type is 'Fiber Optic', create or update the TV plan and packages
            if ($planData['plan_type_id'] === $fiberOpticType->id && $tvPlanData) {
                // Create or update the TV plan
                $tvPlan = TvPlan::firstOrCreate(
                    ['plan_id' => $plan->id],
                    [
                        'name' => $tvPlanData['name'],
                        'description' => $tvPlanData['description'],
                        'price' => $tvPlanData['price'],
                    ]
                );

                // Create or update associated packages for the TV plan, max of 4 packages
                foreach (array_slice($tvPlanData['packages'], 0, 4) as $packageData) {
                    Package::firstOrCreate(
                        ['name' => $packageData['name'], 'tv_plan_id' => $tvPlan->id],
                        $packageData
                    );
                }
            }
        }
    }
}
