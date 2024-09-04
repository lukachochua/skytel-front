<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\TvPlan;
use App\Models\Package;
use Illuminate\Http\Request;

class PlanController extends Controller
{    
    public function index()
    {
        $plans = Plan::all();
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
        $plans = Plan::where('type', 'Fiber Optic')->get();
        return view('admin.plans.create', compact('plans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'type' => 'required|string',
            'tv_plan_name' => 'nullable|string|max:255',
            'tv_plan_description' => 'nullable|string',
            'tv_plan_price' => 'nullable|numeric',
            'packages.*.name' => 'nullable|string|max:255',
            'packages.*.price' => 'nullable|numeric',
        ]);

        // Create the main plan
        $plan = Plan::create($request->only(['name', 'description', 'price', 'type']));

        if ($request->type === 'Fiber Optic' && $request->filled('tv_plan_name')) {
            // Create a TV plan if the main plan is Fiber Optic
            $tvPlan = TvPlan::create([
                'name' => $request->tv_plan_name,
                'description' => $request->tv_plan_description,
                'price' => $request->tv_plan_price,
                'plan_id' => $plan->id,
            ]);

            // Create packages for the TV plan
            foreach ($request->packages as $package) {
                if (!empty($package['name'])) {
                    Package::create([
                        'name' => $package['name'],
                        'price' => $package['price'],
                        'tv_plan_id' => $tvPlan->id,
                    ]);
                }
            }
        }

        return redirect()->route('home.plans.index')->with('success', 'Plan created successfully.');
    }

    public function edit(Plan $plan)
    {
        $tvPlans = TvPlan::where('plan_id', $plan->id)->get();
        return view('plans.edit', compact('plan', 'tvPlans'));
    }

    public function update(Request $request, Plan $plan)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'type' => 'required|string',
            'tv_plan_name' => 'nullable|string|max:255',
            'tv_plan_description' => 'nullable|string',
            'tv_plan_price' => 'nullable|numeric',
            'packages.*.name' => 'nullable|string|max:255',
            'packages.*.price' => 'nullable|numeric',
        ]);

        // Update the main plan
        $plan->update($request->only(['name', 'description', 'price', 'type']));

        if ($plan->type === 'Fiber Optic') {
            if ($request->filled('tv_plan_name')) {
                // Update or create a TV plan if the main plan is Fiber Optic
                $tvPlan = TvPlan::updateOrCreate(
                    ['plan_id' => $plan->id],
                    [
                        'name' => $request->tv_plan_name,
                        'description' => $request->tv_plan_description,
                        'price' => $request->tv_plan_price,
                    ]
                );

                // Update or create packages for the TV plan
                foreach ($request->packages as $package) {
                    if (!empty($package['name'])) {
                        Package::updateOrCreate(
                            ['id' => $package['id'] ?? null],
                            [
                                'name' => $package['name'],
                                'price' => $package['price'],
                                'tv_plan_id' => $tvPlan->id,
                            ]
                        );
                    }
                }
            } else {
                // Remove TV plan and packages if TV plan data is not provided
                TvPlan::where('plan_id', $plan->id)->delete();
            }
        }

        return redirect()->route('home.plans.index')->with('success', 'Plan updated successfully.');
    }

    public function destroy(Plan $plan)
    {
        // Delete associated TV plans and packages
        $tvPlans = TvPlan::where('plan_id', $plan->id)->get();
        foreach ($tvPlans as $tvPlan) {
            Package::where('tv_plan_id', $tvPlan->id)->delete();
            $tvPlan->delete();
        }

        $plan->delete();
        return redirect()->route('home.plans.index')->with('success', 'Plan deleted successfully.');
    }
}
