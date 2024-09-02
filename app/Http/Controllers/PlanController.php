<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\PlanType;
use App\Models\TvOption;
use App\Models\PlanOption;
use App\Models\TvService;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index()
    {
        return view('plans.index');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'plan_type_id' => 'required|exists:plan_types,id',
            'description' => 'nullable|string',
            'status' => 'required|string|in:active,inactive',
        ]);

        $plan = Plan::create($validatedData);

        if ($plan->planType->name === 'fiber_optic' && $request->has('tv_services')) {
            foreach ($request->tv_services as $tvServiceData) {
                $tvService = $plan->tvServices()->create([
                    'name' => $tvServiceData['name'],
                    'price' => $tvServiceData['price'],
                ]);

                foreach ($tvServiceData['options'] as $optionData) {
                    $tvService->serviceOptions()->create($optionData);
                }
            }
        }

        // Additional logic for PlanOptions or other related entities

        return redirect()->route('plans.dashboard')->with('success', 'Plan created successfully!');
    }

    public function edit($id)
    {
        $plan = Plan::with('planOptions', 'tvServices.tvServiceOptions')->findOrFail($id);

        $tvServices = null;
        if ($plan->plan_type_id === 1) {
            $tvServices = TvService::with('tvServiceOptions')
                ->where('plan_id', $plan->id)
                ->get();
        }


        return view('admin.plans.edit', compact('plan', 'tvServices'));
    }
}
