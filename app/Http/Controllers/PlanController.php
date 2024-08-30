<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\PlanType;
use App\Models\TvOption;
use App\Models\PlanOption;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'plan_type_id' => 'required|exists:plan_types,id',
            'description' => 'nullable|string',
            'status' => 'required|string|in:active,inactive',
        ]);

        $plan = Plan::create($validatedData);

        if ($plan->planType->name === 'tv') {
            $tvOptionData = $request->validate([
                'setanta' => 'boolean',
            ]);

            $plan->tvOption()->create($tvOptionData);
        }


        return redirect()->route('plans.index')->with('success', 'Plan created successfully!');
    }
}
