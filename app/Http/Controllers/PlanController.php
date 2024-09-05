<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\TvPlan;
use App\Models\PlanType;
use App\Models\Package;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index()
    {
        $plans = Plan::with('planType')->get();
        return view('plans.index', compact('plans'));
    }

    public function show($id)
    {
        $plan = Plan::findOrFail($id);
        return view('plans.show', compact('plan'));
    }

    public function dashboard()
    {
        $plans = Plan::all();
        return view('admin.plans.index', compact('plans'));
    }

    public function create()
    {
        $planTypes = PlanType::all();
        $fiberOpticType = PlanType::where('name', 'Fiber Optic')->first();


        return view('admin.plans.create', [
            'planTypes' => $planTypes,
            'fiberOpticTypeId' => $fiberOpticType ? $fiberOpticType->id : null
        ]);
    }

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'plan_type_id' => 'required',

            'tv_plan_name' => 'nullable|string|max:255',
            'tv_plan_description' => 'nullable|string',
            'tv_plan_price' => 'nullable|numeric',

            'packages.*.name' => 'nullable|string|max:255',
            'packages.*.price' => 'nullable|numeric',
        ]);

        // Create the plan
        $planData = [
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'price' => $validatedData['price'],
            'plan_type_id' => $validatedData['plan_type_id'],
        ];

        $plan = Plan::create($planData);

        // Handle Fiber Optic type specifics
        if ($validatedData['plan_type_id'] === $this->getFiberOpticTypeId()) {
            $tvPlanData = [
                'name' => $validatedData['tv_plan_name'] ?? null,
                'description' => $validatedData['tv_plan_description'] ?? null,
                'price' => $validatedData['tv_plan_price'] ?? null,
            ];

            $tvPlan = $this->createTvPlan($plan->id, $tvPlanData);

            $packagesData = $validatedData['packages'] ?? [];
            $this->createPackages($tvPlan->id, $packagesData);
        }

        return redirect()->route('plans.index')->with('success', 'Plan created successfully.');
    }

    public function edit(Plan $plan)
    {
        $tvPlan = $plan->tvPlans()->first();
        return view('admin.plans.edit', compact('plan', 'tvPlan'));
    }

    public function update(Request $request, Plan $plan)
    {
        // Validate the request
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'plan_type_id' => 'required|integer|exists:plan_types,id',

            'tv_plan_name' => 'nullable|string|max:255',
            'tv_plan_description' => 'nullable|string',
            'tv_plan_price' => 'nullable|numeric',

            'packages.*.id' => 'nullable|integer|exists:packages,id',
            'packages.*.name' => 'nullable|string|max:255',
            'packages.*.price' => 'nullable|numeric',
        ]);

        // Update the plan
        $plan->update($validatedData);

        // Handle Fiber Optic type specifics
        if ($validatedData['plan_type_id'] === $this->getFiberOpticTypeId()) {
            $tvPlanData = [
                'name' => $validatedData['tv_plan_name'] ?? null,
                'description' => $validatedData['tv_plan_description'] ?? null,
                'price' => $validatedData['tv_plan_price'] ?? null,
            ];

            $tvPlan = $this->updateOrCreateTvPlan($plan->id, $tvPlanData);

            $packagesData = $validatedData['packages'] ?? [];
            $this->updateOrCreatePackages($tvPlan->id, $packagesData);
        } else {
            $this->deleteTvPlanAndPackages($plan);
        }

        return redirect()->route('plans.dashboard')->with('success', 'Plan updated successfully.');
    }

    public function destroy(Plan $plan)
    {
        $this->deleteTvPlanAndPackages($plan);
        $plan->delete();

        return redirect()->route('plans.index')->with('success', 'Plan deleted successfully.');
    }

    // Helper methods
    private function getFiberOpticTypeId()
    {
        return PlanType::where('name', 'Fiber Optic')->value('id');
    }

    private function createTvPlan($planId, $tvPlanData)
    {
        return TvPlan::create(array_merge($tvPlanData, ['plan_id' => $planId]));
    }

    private function createPackages($tvPlanId, $packagesData)
    {
        foreach ($packagesData as $package) {
            if (!empty($package['name'])) {
                Package::create([
                    'name' => $package['name'],
                    'price' => $package['price'],
                    'tv_plan_id' => $tvPlanId,
                ]);
            }
        }
    }

    private function updateOrCreateTvPlan($planId, $tvPlanData)
    {
        return TvPlan::updateOrCreate(
            ['plan_id' => $planId],
            $tvPlanData
        );
    }

    private function updateOrCreatePackages($tvPlanId, $packagesData)
    {
        foreach ($packagesData as $package) {
            if (!empty($package['name'])) {
                Package::updateOrCreate(
                    ['id' => $package['id'] ?? null],
                    [
                        'name' => $package['name'],
                        'price' => $package['price'],
                        'tv_plan_id' => $tvPlanId,
                    ]
                );
            }
        }
    }

    private function deleteTvPlanAndPackages(Plan $plan)
    {
        if ($plan->tvPlans()->exists()) {
            $tvPlan = $plan->tvPlans()->first();
            $tvPlan->packages()->delete();
            $tvPlan->delete();
        }
    }
}
