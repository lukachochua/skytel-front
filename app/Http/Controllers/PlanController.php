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

        Plan::create($validatedData);

        return redirect()->route('admin.plans.index')->with('success', 'Plan created successfully!');
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

        return redirect()->route('admin.plans.index')->with('success', 'Plan updated successfully!');
    }

    public function destroy(Plan $plan)
    {
        $plan->delete();

        return redirect()->route('admin.plans.index')->with('success', 'Plan deleted successfully!');
    }
}
