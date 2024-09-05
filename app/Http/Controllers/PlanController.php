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
                    Package::create([
                        'tv_plan_id' => $tvPlan->id,
                        'name' => $package['name'],
                        'price' => $package['price'],
                    ]);
                }
            }
        }

        return redirect()->route('plans.dashboard')->with('success', 'Plan created successfully.');
    }

    public function edit(Plan $plan)
    {
        $tvPlan = $plan->tvPlans()->first();
        $packages = $tvPlan ? $tvPlan->packages : collect();
        dd($tvPlan);
        return view('admin.plans.edit', compact('plan', 'tvPlan', 'packages'));
    }


    public function update(Request $request, Plan $plan)
    {
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

        $plan->update([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'price' => $validatedData['price'],
            'plan_type_id' => $validatedData['plan_type_id'],
        ]);

        if ($validatedData['plan_type_id'] == 1) { // Assuming 1 is the ID for Fiber Optic
            $tvPlanData = [
                'name' => $validatedData['tv_plan_name'] ?? null,
                'description' => $validatedData['tv_plan_description'] ?? null,
                'price' => $validatedData['tv_plan_price'] ?? null,
            ];

            $tvPlan = $plan->tvPlans()->updateOrCreate([], $tvPlanData);

            $packagesData = $validatedData['packages'] ?? [];
            foreach ($packagesData as $package) {
                if (isset($package['id'])) {
                    $tvPlan->packages()->updateOrCreate(['id' => $package['id']], [
                        'name' => $package['name'],
                        'price' => $package['price'],
                    ]);
                } else {
                    $tvPlan->packages()->create([
                        'name' => $package['name'],
                        'price' => $package['price'],
                    ]);
                }
            }
        } else {
            $plan->tvPlans()->delete(); // Delete TV Plan and associated packages if not Fiber Optic
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
