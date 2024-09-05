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
            'price' => 'required|numeric|min:0|max:999999',
            'plan_type_id' => 'required|exists:plan_types,id',
            'tv_plan_name' => 'nullable|string|max:255',
            'tv_plan_description' => 'nullable|string',
            'tv_plan_price' => 'nullable|numeric|min:0',
            'packages.*.name' => 'nullable|string|max:255',
            'packages.*.price' => 'nullable|numeric|min:0',
        ]);

        $plan = Plan::create([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'price' => $validatedData['price'],
            'plan_type_id' => $validatedData['plan_type_id'],
        ]);

        if ($validatedData['plan_type_id'] == $this->getFiberOpticTypeId()) {
            if (empty($validatedData['tv_plan_name']) || empty($validatedData['tv_plan_price'])) {
                return redirect()->back()->withErrors([
                    'tv_plan_name' => 'TV Plan details are required for Fiber Optic plans.'
                ])->withInput();
            }

            $tvPlan = TvPlan::create([
                'plan_id' => $plan->id,
                'name' => $validatedData['tv_plan_name'],
                'description' => $validatedData['tv_plan_description'],
                'price' => $validatedData['tv_plan_price'],
            ]);

            if (!$tvPlan) {
                return redirect()->back()->withErrors(['tv_plan_name' => 'Failed to create TV Plan.'])
                    ->withInput();
            }

            if (!empty($validatedData['packages'])) {
                foreach ($validatedData['packages'] as $package) {
                    if (!empty($package['name']) && !empty($package['price'])) {
                        Package::create([
                            'tv_plan_id' => $tvPlan->id,
                            'name' => $package['name'],
                            'price' => $package['price'],
                        ]);
                    }
                }
            }
        }

        return redirect()->route('plans.dashboard')->with('success', 'Plan created successfully.');
    }

    public function edit(Plan $plan)
    {
        $tvPlan = $plan->tvPlans()->first();
        $packages = $tvPlan ? $tvPlan->packages : collect();
        return view('admin.plans.edit', compact('plan', 'tvPlan', 'packages'));
    }


    public function update(Request $request, Plan $plan)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0|max:999999',
            'plan_type_id' => 'required|exists:plan_types,id',
            'tv_plan_name' => 'nullable|string|max:255',
            'tv_plan_description' => 'nullable|string',
            'tv_plan_price' => 'nullable|numeric|min:0',
            'packages.*.id' => 'nullable|integer|exists:packages,id',
            'packages.*.name' => 'nullable|string|max:255',
            'packages.*.price' => 'nullable|numeric|min:0',
        ]);

        // Update the plan data
        $plan->update([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'price' => $validatedData['price'],
            'plan_type_id' => $validatedData['plan_type_id'],
        ]);

        // Handle Fiber Optic Plan
        if ($validatedData['plan_type_id'] == $this->getFiberOpticTypeId()) {
            // Validate that TV Plan details are filled out
            if (empty($validatedData['tv_plan_name']) || empty($validatedData['tv_plan_price'])) {
                return redirect()->back()->withErrors([
                    'tv_plan_name' => 'TV Plan details are required for Fiber Optic plans.'
                ])->withInput();
            }

            // Update or create the associated TV Plan
            $tvPlanData = [
                'name' => $validatedData['tv_plan_name'],
                'description' => $validatedData['tv_plan_description'],
                'price' => $validatedData['tv_plan_price'],
            ];
            $tvPlan = $plan->tvPlans()->updateOrCreate(
                ['plan_id' => $plan->id], // Ensure this updates the existing TV Plan
                $tvPlanData
            );

            // Update or create associated packages
            if (!empty($validatedData['packages'])) {
                foreach ($validatedData['packages'] as $package) {
                    if (!empty($package['name']) && !empty($package['price'])) {
                        $tvPlan->packages()->updateOrCreate(
                            ['id' => $package['id'] ?? null], // Update by package ID if it exists
                            [
                                'name' => $package['name'],
                                'price' => $package['price'],
                            ]
                        );
                    }
                }
            }
        } else {
            // If not a Fiber Optic Plan, delete associated TV Plans and Packages
            $plan->tvPlans()->delete();
        }

        return redirect()->route('plans.dashboard')->with('success', 'Plan updated successfully.');
    }


    public function destroy(Plan $plan)
    {
        $this->deleteTvPlanAndPackages($plan);
        $plan->delete();

        return redirect()->route('plans.dashboard')->with('success', 'Plan deleted successfully.');
    }

    // Helper methods
    private function createTvPlan($planId, array $tvPlanData)
    {
        // Logic to create TV Plan
        return TvPlan::create([
            'plan_id' => $planId,
            'name' => $tvPlanData['name'],
            'description' => $tvPlanData['description'],
            'price' => $tvPlanData['price'],
        ]);
    }

    private function createPackages($tvPlanId, array $packagesData)
    {
        foreach ($packagesData as $package) {
            Package::create([
                'tv_plan_id' => $tvPlanId,
                'name' => $package['name'],
                'price' => $package['price'],
            ]);
        }
    }

    private function getFiberOpticTypeId()
    {
        return PlanType::where('id', 2)->value('id');
    }


    public function deletePackage(Request $request, $id)
    {
        $package = Package::find($id);

        if ($package) {
            $package->delete();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Package not found']);
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
