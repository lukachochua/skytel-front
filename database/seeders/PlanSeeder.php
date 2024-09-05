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
        // Predefined PlanTypes
        $internetType = PlanType::create(['name' => 'Internet']);
        $fiberOpticType = PlanType::create(['name' => 'Fiber Optic']);

        // Seed some general plans
        $plans = [
            [
                'name' => 'Basic Internet',
                'description' => 'A basic internet plan suitable for home users.',
                'price' => 19.99,
                'plan_type_id' => $internetType->id, // PlanType reference
            ],
            [
                'name' => 'Fiber Optic Premium',
                'description' => 'High-speed fiber optic internet with additional TV channels.',
                'price' => 99.99,
                'plan_type_id' => $fiberOpticType->id, // PlanType reference
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

        // Iterate over each plan and create them in the database
        foreach ($plans as $planData) {
            $tvPlanData = $planData['tv_plan'] ?? null;
            unset($planData['tv_plan']);

            // Create the main plan
            $plan = Plan::create($planData);

            // If the plan type is 'Fiber Optic', create the TV plan and packages
            if ($planData['plan_type_id'] === $fiberOpticType->id && $tvPlanData) {
                $tvPlan = TvPlan::create([
                    'name' => $tvPlanData['name'],
                    'description' => $tvPlanData['description'],
                    'price' => $tvPlanData['price'],
                    'plan_id' => $plan->id,
                ]);

                // Create associated packages for the TV plan
                foreach ($tvPlanData['packages'] as $packageData) {
                    Package::create([
                        'name' => $packageData['name'],
                        'price' => $packageData['price'],
                        'tv_plan_id' => $tvPlan->id,
                    ]);
                }
            }
        }
    }
}
