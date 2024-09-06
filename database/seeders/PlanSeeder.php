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
        $internetType = PlanType::firstOrCreate(['name' => 'Internet']);
        $fiberOpticType = PlanType::firstOrCreate(['name' => 'Fiber Optic']);

        // Define plans data
        $plans = [
            [
                'name' => 'Basic Internet',
                'description' => 'A basic internet plan suitable for home users.',
                'price' => 19.99,
                'plan_type_id' => $internetType->id, // Ensure this gets the Internet type
            ],
            [
                'name' => 'Fiber Optic Premium',
                'description' => 'High-speed fiber optic internet with additional TV channels.',
                'price' => 99.99,
                'plan_type_id' => $fiberOpticType->id, // Ensure this gets the Fiber Optic type
                'tv_plan' => [
                    'name' => 'Premium TV',
                    'description' => 'Includes over 200 channels with HD quality.',
                    'price' => 29.99,
                    'packages' => [
                        [
                            'name' => 'Sports Package',
                            'price' => 9.99,
                        ],
                        [
                            'name' => 'Movies Package',
                            'price' => 12.99,
                        ],
                    ],
                ],
            ],
        ];

        // Iterate over each plan and create them in the database if they don't exist
        foreach ($plans as $planData) {
            $tvPlanData = $planData['tv_plan'] ?? null;
            unset($planData['tv_plan']);

            // Debug output to confirm PlanType assignment
            if ($planData['plan_type_id'] === $internetType->id) {
                echo "Creating plan '{$planData['name']}' with Internet plan type.\n";
            } elseif ($planData['plan_type_id'] === $fiberOpticType->id) {
                echo "Creating plan '{$planData['name']}' with Fiber Optic plan type.\n";
            }

            // Create or update the plan to avoid duplication
            $plan = Plan::firstOrCreate(
                ['name' => $planData['name']], // Unique identifier for each plan
                $planData
            );

            // If the plan type is 'Fiber Optic', create or update the TV plan and packages
            if ($planData['plan_type_id'] === $fiberOpticType->id && $tvPlanData) {
                // Create or update the TV plan
                $tvPlan = TvPlan::firstOrCreate(
                    ['plan_id' => $plan->id], // Unique by plan_id
                    [
                        'name' => $tvPlanData['name'],
                        'description' => $tvPlanData['description'],
                        'price' => $tvPlanData['price'],
                    ]
                );

                // Create or update associated packages for the TV plan, max of 4 packages
                foreach (array_slice($tvPlanData['packages'], 0, 4) as $packageData) {
                    Package::firstOrCreate(
                        ['name' => $packageData['name'], 'tv_plan_id' => $tvPlan->id], // Unique by name and tv_plan_id
                        $packageData
                    );
                }
            }
        }
    }
}
