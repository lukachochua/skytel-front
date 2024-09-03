<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PlanType;
use App\Models\Plan;
use App\Models\TvService;
use App\Models\TvServiceOption;
use App\Models\PlanOption;

class PlanSeeder extends Seeder
{
    public function run()
    {
        // Seed Plan Types
        $fiberOptic = PlanType::create(['name' => 'fiber_optic', 'description' => 'High-speed fiber optic internet']);
        $wireless = PlanType::create(['name' => 'wireless', 'description' => 'Wireless internet for remote areas']);
        $corporate = PlanType::create(['name' => 'corporate', 'description' => 'Corporate internet plans for businesses']);

        // Seed Fiber Optic Plans
        $fiberPlans = [
            [
                'name' => 'Fiber Basic',
                'description' => 'Basic fiber optic plan',
                'status' => 'active',
            ],
            [
                'name' => 'Fiber Plus',
                'description' => 'Upgraded fiber optic plan with more speed',
                'status' => 'active',
            ],
            [
                'name' => 'Fiber Premium',
                'description' => 'Premium fiber optic plan with highest speed',
                'status' => 'active',
            ],
        ];

        // Seed Fiber Plans and associated TV Services
        foreach ($fiberPlans as $fiberPlanData) {
            $fiberPlan = Plan::create(array_merge($fiberPlanData, ['plan_type_id' => $fiberOptic->id]));

            // Seed TV Service for the Fiber Optic Plan
            $tvService = TvService::create([
                'plan_id' => $fiberPlan->id,
                'name' => 'Basic TV',
                'price' => 10.00,
            ]);

            // Associate the TV Service Option with the current TV Service
            TvServiceOption::create([
                'tv_service_id' => $tvService->id, // Ensure tv_service_id is populated
                'option_name' => 'Setanta',
                'enabled' => true,
                'additional_price' => 5.00,
            ]);

            // Seed Plan Options for Fiber Plan
            $planOptions = [
                [
                    'option_name' => 'Pro',
                    'price' => 30.00,
                ],
                [
                    'option_name' => 'Ultra',
                    'price' => 50.00,
                ],
            ];

            foreach ($planOptions as $planOptionData) {
                PlanOption::create(array_merge($planOptionData, ['plan_id' => $fiberPlan->id]));
            }
        }

        // Seed Wireless Plans
        $wirelessPlans = [
            [
                'name' => 'Wireless Basic',
                'description' => 'Basic wireless internet plan',
                'status' => 'active',
            ],
            [
                'name' => 'Wireless Plus',
                'description' => 'Upgraded wireless plan for better coverage',
                'status' => 'active',
            ],
            [
                'name' => 'Wireless Premium',
                'description' => 'Premium wireless plan with highest coverage and speed',
                'status' => 'active',
            ],
        ];

        foreach ($wirelessPlans as $wirelessPlanData) {
            $wirelessPlan = Plan::create(array_merge($wirelessPlanData, ['plan_type_id' => $wireless->id]));

            // Seed Plan Options for Wireless Plan
            $planOptions = [
                [
                    'option_name' => 'Pro',
                    'price' => 25.00,
                ],
                [
                    'option_name' => 'Ultra',
                    'price' => 45.00,
                ],
            ];

            foreach ($planOptions as $planOptionData) {
                PlanOption::create(array_merge($planOptionData, ['plan_id' => $wirelessPlan->id]));
            }
        }

        // Seed Corporate Plans
        $corporatePlans = [
            [
                'name' => 'Corporate Basic',
                'description' => 'Basic corporate internet plan for small businesses',
                'status' => 'active',
            ],
            [
                'name' => 'Corporate Plus',
                'description' => 'Enhanced corporate plan with additional features',
                'status' => 'active',
            ],
            [
                'name' => 'Corporate Premium',
                'description' => 'Premium corporate plan for large enterprises',
                'status' => 'active',
            ],
        ];

        foreach ($corporatePlans as $corporatePlanData) {
            $corporatePlan = Plan::create(array_merge($corporatePlanData, ['plan_type_id' => $corporate->id]));

            // Seed Plan Options for Corporate Plan
            $planOptions = [
                [
                    'option_name' => 'Pro',
                    'price' => 100.00,
                ],
                [
                    'option_name' => 'Ultra',
                    'price' => 200.00,
                ],
            ];

            foreach ($planOptions as $planOptionData) {
                PlanOption::create(array_merge($planOptionData, ['plan_id' => $corporatePlan->id]));
            }
        }
    }
}
