<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\PlanOption;
use Illuminate\Http\Request;

class PlanOptionController extends Controller
{
    public function index()
    {
        $planOptions = PlanOption::with('plan')->get();
        return view('planOptions.index', compact('planOptions'));
    }

    public function create()
    {
        $plans = Plan::all();
        return view('planOptions.create', compact('plans'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'plan_id' => 'required|exists:plans,id',
            'name' => 'required|string|max:255',
            'price' => 'required|integer|min:0',
            'description' => 'nullable|string',
        ]);

        PlanOption::create($validatedData);

        return redirect()->route('planOptions.index')->with('success', 'Plan Option created successfully!');
    }

    public function show(PlanOption $planOption)
    {
        return view('planOptions.show', compact('planOption'));
    }

    public function edit(PlanOption $planOption)
    {
        $plans = Plan::all();
        return view('planOptions.edit', compact('planOption', 'plans'));
    }

    public function update(Request $request, PlanOption $planOption)
    {
        $validatedData = $request->validate([
            'plan_id' => 'required|exists:plans,id',
            'name' => 'required|string|max:255',
            'price' => 'required|integer|min:0',
            'description' => 'nullable|string',
        ]);

        $planOption->update($validatedData);

        return redirect()->route('planOptions.index')->with('success', 'Plan Option updated successfully!');
    }

    public function destroy(PlanOption $planOption)
    {
        $planOption->delete();

        return redirect()->route('planOptions.index')->with('success', 'Plan Option deleted successfully!');
    }
}
