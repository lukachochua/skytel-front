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

        // Use a database transaction
        DB::beginTransaction();

        try {
            // Create the Plan first
            $plan = Plan::create([
                'name' => $validatedData['name'],
                'description' => $validatedData['description'],
                'price' => $validatedData['price'],
                'plan_type_id' => $validatedData['plan_type_id'],
            ]);

            // Check if the plan type is Fiber Optic
            if ($validatedData['plan_type_id'] == $this->getFiberOpticTypeId()) {
                // Ensure TV plan details are provided
                if (empty($validatedData['tv_plan_name']) || empty($validatedData['tv_plan_price'])) {
                    throw new \Exception('TV Plan details are required for Fiber Optic plans.');
                }

                // Create the TV Plan
                $tvPlan = TvPlan::create([
                    'plan_id' => $plan->id,
                    'name' => $validatedData['tv_plan_name'],
                    'description' => $validatedData['tv_plan_description'],
                    'price' => $validatedData['tv_plan_price'],
                ]);

                // Check for packages and create them
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

            // Commit the transaction
            DB::commit();

            return redirect()->route('plans.dashboard')->with('success', 'Plan created successfully.');
        } catch (\Exception $e) {
            // Rollback the transaction if there's any error
            DB::rollBack();

            // Return with errors and input if something went wrong
            return redirect()->back()->withErrors([
                'tv_plan_name' => $e->getMessage(),
            ])->withInput();
        }
    }

    public function edit($id)
    {
        $plan = Plan::findOrFail($id);
        $tvPlan = $plan->tvPlans->first();
        $planTypes = PlanType::all(); // 
        $fiberOpticTypeId = PlanType::where('name', 'Fiber Optic')->first()->id; // Get Fiber Optic type ID

        return view('admin.plans.edit', compact('plan', 'tvPlan', 'planTypes', 'fiberOpticTypeId'));
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

        try {
            $plan->update([
                'name' => $validatedData['name'],
                'description' => $validatedData['description'],
                'price' => $validatedData['price'],
                'plan_type_id' => $validatedData['plan_type_id'],
            ]);

            if ($validatedData['plan_type_id'] == $this->getFiberOpticTypeId()) {
                if (empty($validatedData['tv_plan_name']) || empty($validatedData['tv_plan_price'])) {
                    Log::error('TV Plan details missing for Fiber Optic plan');
                    return redirect()->back()->withErrors([
                        'tv_plan_name' => 'TV Plan details are required for Fiber Optic plans.'
                    ])->withInput();
                }

                $tvPlanData = [
                    'name' => $validatedData['tv_plan_name'],
                    'description' => $validatedData['tv_plan_description'],
                    'price' => $validatedData['tv_plan_price'],
                ];

                $tvPlan = $plan->tvPlans()->updateOrCreate(
                    ['plan_id' => $plan->id],
                    $tvPlanData
                );
                Log::info('Updated or Created TV Plan: ', $tvPlan->toArray());

                if (!empty($validatedData['packages'])) {
                    foreach ($validatedData['packages'] as $package) {
                        if (!empty($package['name']) && !empty($package['price'])) {
                            $updatedPackage = $tvPlan->packages()->updateOrCreate(
                                ['id' => $package['id'] ?? null],
                                [
                                    'name' => $package['name'],
                                    'price' => $package['price'],
                                ]
                            );
                            Log::info('Updated or Created Package: ', $updatedPackage->toArray());
                        }
                    }
                }
            } else {
                $plan->tvPlans()->delete();
            }

            Log::info('Redirecting to plans.dashboard with success message.');
            return redirect()->route('plans.dashboard')->with('success', 'Plan updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error updating plan: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Failed to update the plan. Please try again.'])->withInput();
        }
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
