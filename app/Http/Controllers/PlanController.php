<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index()
    {
        $plans = Plan::all();
        return view('plans.index', compact('plans'));
    }

    public function create()
    {
        return view('admin.plans.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:fiber_optic,wireless,tv,corporate',
            'description' => 'nullable|string',
            'status' => 'required|string|in:active,inactive',
            'setanta' => 'boolean',
        ]);

        $plan = Plan::create($validatedData);

        if ($request->has('options')) {
            foreach ($request->options as $option) {
                $plan->planOptions()->create([
                    'name' => $option['name'],
                    'price' => $option['price'],
                    'description' => $option['description'],
                ]);
            }
        }

        return redirect()->route('plans.dashboard')->with('success', 'Plan created successfully!');
    }


    public function show(Plan $plan)
    {
        return view('plans.show', compact('plan'));
    }

    public function edit(Plan $plan)
    {
        return view('admin.plans.edit', compact('plan'));
    }

    public function update(Request $request, Plan $plan)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:fiber_optic,wireless,tv,corporate',
            'description' => 'nullable|string',
            'status' => 'required|string|in:active,inactive',
            'setanta' => 'boolean',
        ]);

        $plan->update($validatedData);

        if ($request->has('options')) {
            $optionIds = [];

            foreach ($request->options as $optionId => $option) {
                if ($planOption = $plan->planOptions()->find($optionId)) {
                    $planOption->update([
                        'name' => $option['name'],
                        'price' => $option['price'],
                        'description' => $option['description'],
                    ]);
                } else {
                    $newOption = $plan->planOptions()->create([
                        'name' => $option['name'],
                        'price' => $option['price'],
                        'description' => $option['description'],
                    ]);
                    $optionId = $newOption->id;
                }
                $optionIds[] = $optionId;
            }

            $plan->planOptions()->whereNotIn('id', $optionIds)->delete();
        } else {
            $plan->planOptions()->delete();
        }

        return redirect()->route('plans.dashboard')->with('success', 'Plan updated successfully!');
    }

    public function destroy(Plan $plan)
    {
        $plan->delete();

        return redirect()->route('plans.dashboard')->with('success', 'Plan deleted successfully!');
    }
}
