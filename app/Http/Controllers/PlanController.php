<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\TvPlan;
use App\Models\PlanType;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        $tvPlan = $plan->tvPlans->first();
        return view('plans.show', compact('plan', 'tvPlan'));
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

        DB::beginTransaction();

        try {
            $plan = Plan::create([
                'name' => $validatedData['name'],
                'description' => $validatedData['description'],
                'price' => $validatedData['price'],
                'plan_type_id' => $validatedData['plan_type_id'],
            ]);

            if ($validatedData['plan_type_id'] == $this->getFiberOpticTypeId()) {
                if (empty($validatedData['tv_plan_name']) || empty($validatedData['tv_plan_price'])) {
                    throw new \Exception('TV Plan details are required for Fiber Optic plans.');
                }

                $tvPlan = TvPlan::create([
                    'plan_id' => $plan->id,
                    'name' => $validatedData['tv_plan_name'],
                    'description' => $validatedData['tv_plan_description'],
                    'price' => $validatedData['tv_plan_price'],
                ]);

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

            DB::commit();

            return redirect()->route('plans.dashboard')->with('success', 'Plan created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->withErrors([
                'tv_plan_name' => $e->getMessage(),
            ])->withInput();
        }
    }

    public function edit($id)
    {
        $plan = Plan::with('tvPlans.packages')->findOrFail($id);
        $planTypes = PlanType::all();
        $fiberOpticType = PlanType::where('name', 'Fiber Optic')->first();

        return view('admin.plans.edit', [
            'plan' => $plan,
            'planTypes' => $planTypes,
            'fiberOpticTypeId' => $fiberOpticType ? $fiberOpticType->id : null
        ]);
    }


    public function update(Request $request, $id)
    {
        $plan = Plan::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'plan_type_id' => 'required|integer',
            'tv_plans.*.name' => 'nullable|string|max:255',
            'tv_plans.*.description' => 'nullable|string',
            'tv_plans.*.price' => 'nullable|numeric',
        ]);

        $plan->update($validatedData);

        foreach ($request->tv_plans as $tvPlanData) {
            if (isset($tvPlanData['id'])) {
                $tvPlan = TvPlan::find($tvPlanData['id']);
                if ($tvPlan) {
                    $tvPlan->update($tvPlanData);
                }
            } else {
                $plan->tvPlans()->create($tvPlanData); 
            }
        }

        return redirect()->route('plans.index')->with('success', 'Plan updated successfully');
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
