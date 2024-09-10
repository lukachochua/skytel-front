<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\TvPlan;
use App\Models\PlanType;
use App\Models\Package;
use App\Models\PlanSelection;
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
        $fiberOpticType = PlanType::where('name', '{"ka":"Fiber Optic"}')->first(); // Example

        $packages = []; // Initialize with an empty array if no packages are available

        if ($plan->plan_type_id == $fiberOpticType->id && $plan->tvPlans->count() > 0) {
            $firstTvPlan = $plan->tvPlans->first();
            $packages = $firstTvPlan->packages->map(function ($package) {
                return [
                    'id' => $package->id,
                    'name' => $package->name,
                    'price' => $package->price,
                ];
            })->toArray();
        }


        return view('plans.show',  compact('plan', 'fiberOpticType', 'packages'));
    }

    public function dashboard()
    {
        $plans = Plan::all();
        return view('admin.plans.index', compact('plans'));
    }

    public function create()
    {
        $planTypes = PlanType::all();
        $fiberOpticType = PlanType::where('id', 2)->first();


        return view('admin.plans.create', [
            'planTypes' => $planTypes,
            'fiberOpticTypeId' => $fiberOpticType ? $fiberOpticType->id : null
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'description' => 'required|string',
            'description_en' => 'required|string',
            'price' => 'required|numeric|min:0|max:999999',
            'plan_type_id' => 'required|exists:plan_types,id',
            'tv_plan_name' => 'nullable|string|max:255',
            'tv_plan_name_en' => 'nullable|string|max:255',
            'tv_plan_description' => 'nullable|string',
            'tv_plan_description_en' => 'nullable|string',
            'tv_plan_price' => 'nullable|numeric|min:0',
            'packages.*.name' => 'nullable|string|max:255',
            'packages.*.name_en' => 'nullable|string|max:255',
            'packages.*.price' => 'nullable|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            $plan = Plan::create([
                'name' => $validatedData['name'],
                'name_en' => $validatedData['name_en'],
                'description' => $validatedData['description'],
                'description_en' => $validatedData['description_en'],
                'price' => $validatedData['price'],
                'plan_type_id' => $validatedData['plan_type_id'],
            ]);

            $plan->setTranslations('name', [
                'ka' => $validatedData['name'],
                'en' => $validatedData['name_en'],
            ]);

            $plan->setTranslations('description', [
                'ka' => $validatedData['description'],
                'en' => $validatedData['description_en'],
            ]);

            $plan->save();

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

                $tvPlan->setTranslations('name', [
                    'ka' => $request->input('tv_plan_name'),
                    'en' => $request->input('tv_plan_name_en')
                ]);

                $tvPlan->setTranslations('description', [
                    'ka' => $request->input('tv_plan_description'),
                    'en' => $request->input('tv_plan_description_en')
                ]);

                $tvPlan->save();

                if (!empty($validatedData['packages'])) {
                    foreach ($validatedData['packages'] as $package) {
                        if (!empty($package['name']) && !empty($package['price'])) {
                            $newPackage = Package::create([
                                'tv_plan_id' => $tvPlan->id,
                                'name' => $package['name'],
                                'price' => $package['price'],
                            ]);

                            $newPackage->setTranslations('name', [
                                'ka' => $package['name'],
                                'en' => $package['name_en'],
                            ]);

                            $newPackage->save();
                        }
                    }
                }
            }

            DB::commit();

            return redirect()->route('plans.dashboard')->with('success', __('messages.plan_created'));
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->withErrors([
                'tv_plan_name' => $e->getMessage(),
            ])->withInput();
        }
    }

    public function edit(Plan $plan)
    {
        $plan->load('tvPlans.packages');
        $planTypes = PlanType::all();
        $fiberOpticType = PlanType::where('name', '{"ka":"Fiber Optic"}')->first();

        return view('admin.plans.edit', compact('plan', 'planTypes', 'fiberOpticType'));
    }

    public function update(Request $request, Plan $plan)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0|max:999999',
            'plan_type_id' => 'required|exists:plan_types,id',
            'tv_plans_name' => 'nullable|string|max:255',
            'tv_plans_description' => 'nullable|string',
            'tv_plans_price' => 'nullable|numeric|min:0',
            'packages' => 'nullable|array',
            'packages.*.id' => 'nullable|exists:packages,id',
            'packages.*.name' => 'required_with:packages.*.id|string|max:255',
            'packages.*.price' => 'required_with:packages.*.id|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            $plan->update([
                'name' => $validatedData['name'],
                'description' => $validatedData['description'],
                'price' => $validatedData['price'],
                'plan_type_id' => $validatedData['plan_type_id'],
            ]);

            if ($validatedData['plan_type_id'] == $this->getFiberOpticTypeId()) {
                if (empty($validatedData['tv_plans_name']) || empty($validatedData['tv_plans_price'])) {
                    throw new \Exception('TV Plan details are required for Fiber Optic plans.');
                }

                $tvPlan = $plan->tvPlans->first() ?? new TvPlan(['plan_id' => $plan->id]);
                $tvPlan->fill([
                    'name' => $validatedData['tv_plans_name'],
                    'description' => $validatedData['tv_plans_description'],
                    'price' => $validatedData['tv_plans_price'],
                ]);
                $tvPlan->save();

                if (!empty($validatedData['packages'])) {
                    $existingPackageIds = [];
                    foreach ($validatedData['packages'] as $packageData) {
                        if (!empty($packageData['id'])) {
                            $package = Package::find($packageData['id']);
                            $package->update([
                                'name' => $packageData['name'],
                                'price' => $packageData['price'],
                            ]);
                        } else {
                            $package = Package::create([
                                'tv_plan_id' => $tvPlan->id,
                                'name' => $packageData['name'],
                                'price' => $packageData['price'],
                            ]);
                        }
                        $existingPackageIds[] = $package->id;
                    }

                    Package::where('tv_plan_id', $tvPlan->id)
                        ->whereNotIn('id', $existingPackageIds)
                        ->delete();
                } else {
                    Package::where('tv_plan_id', $tvPlan->id)->delete();
                }
            } else {
                if ($plan->tvPlans->count() > 0) {
                    $tvPlan = $plan->tvPlans->first();
                    Package::where('tv_plan_id', $tvPlan->id)->delete();
                    $tvPlan->delete();
                }
            }

            DB::commit();

            return redirect()->route('plans.dashboard')->with('success', __('messages.plan_updated'));
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->withErrors([
                'tv_plans_name' => $e->getMessage(),
            ])->withInput();
        }
    }


    public function destroy(Plan $plan)
    {
        $this->deleteTvPlanAndPackages($plan);
        $plan->delete();

        return redirect()->route('plans.dashboard')->with('success', __('messages.plan_deleted'));
    }

    public function storeSelection(Request $request, $planId)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'tv_plan_id' => 'nullable|exists:tv_plans,id',
            'packages.*' => 'nullable|exists:packages,id'
        ]);

        PlanSelection::create([
            'plan_id' => $planId,
            'name' => $validatedData['name'],
            'phone' => $validatedData['phone'],
            'tv_plan_id' => $validatedData['tv_plan_id'] ?? null,
            'packages' => json_encode($validatedData['packages'] ?? [])
        ]);

        return redirect()->route('plans.show', $planId)->with('success', 'Your selection has been saved successfully!');
    }

    // Helper methods
    private function getFiberOpticTypeId()
    {
        return PlanType::where('name', '{"ka":"Fiber Optic"}')->first()->id;
    }

    private function createTvPlan($planId, array $tvPlanData)
    {
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
