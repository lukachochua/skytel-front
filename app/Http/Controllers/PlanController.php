<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\PlanType;
use App\Models\PlanOption;
use App\Models\TvService;
use App\Models\TvServiceOption;
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
        $tvServices = TvService::all();
        $tvServiceOptions = TvServiceOption::all();
        $planTypes = PlanType::all();

        return view('admin.plans.create', compact('tvServices', 'tvServiceOptions', 'planTypes'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'plan_type_id' => 'required|exists:plan_types,id',
            'description' => 'nullable|string',
            'status' => 'required|string',
            'services' => 'array',
            'services.*.name' => 'required|string|max:255',
            'services.*.price' => 'required|numeric',
            'services.*.options' => 'array',
            'services.*.options.*.option_name' => 'required|string|max:255',
            'services.*.options.*.additional_price' => 'nullable|numeric',
            'services.*.options.*.enabled' => 'boolean',
        ]);

        $plan = Plan::create([
            'name' => $validatedData['name'],
            'plan_type_id' => $validatedData['plan_type_id'],
            'description' => $validatedData['description'] ?? null,
            'status' => $validatedData['status'],
        ]);

        if ($request->has('services')) {
            foreach ($validatedData['services'] as $serviceData) {
                $service = $plan->tvServices()->create([
                    'name' => $serviceData['name'],
                    'price' => $serviceData['price'],
                ]);

                if (isset($serviceData['options'])) {
                    foreach ($serviceData['options'] as $optionData) {
                        $service->tvServiceOptions()->create([
                            'option_name' => $optionData['option_name'],
                            'additional_price' => $optionData['additional_price'] ?? null,
                            'enabled' => $optionData['enabled'] ?? false,
                        ]);
                    }
                }
            }
        }

        return redirect()->route('plans.dashboard')->with('success', 'Plan created successfully.');
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

    public function update(Request $request, $id)
    {
        $plan = Plan::with('planOptions', 'tvServices.tvServiceOptions')->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:fiber_optic,wireless,tv,corporate',
            'description' => 'nullable|string',
            'status' => 'required|string|in:active,inactive',
            'services.*.options.*.option_name' => 'required_if:type,fiber_optic|string|max:255',
            'services.*.options.*.additional_price' => 'required_if:type,fiber_optic|numeric|min:0',
        ]);

        $plan->update([
            'name' => $request->input('name'),
            'type' => $request->input('type'),
            'description' => $request->input('description'),
            'status' => $request->input('status'),
        ]);

        // Update the TV services if the plan type is fiber optic
        if ($plan->plan_type_id === 1 && $request->has('services')) {
            foreach ($request->input('services') as $serviceId => $serviceData) {
                $service = $plan->tvServices()->find($serviceId);

                if ($service) {
                    foreach ($serviceData['options'] as $optionId => $optionData) {
                        $option = $service->tvServiceOptions()->find($optionId);

                        if ($option) {
                            $option->update([
                                'option_name' => $optionData['option_name'],
                                'additional_price' => $optionData['additional_price'],
                                'enabled' => isset($optionData['enabled']) && $optionData['enabled'] === 'on' ? true : false,
                            ]);
                        }
                    }
                }
            }
        }

        return redirect()->route('plans.edit', $plan->id)
            ->with('success', __('plans.plan_updated_successfully'));
    }

    public function destroy($id)
    {
        $plan = Plan::findOrFail($id);

        foreach ($plan->planOptions as $option) {
            $option->delete();
        }

        if ($plan->tvService) {
            foreach ($plan->tvService->tvServiceOptions as $serviceOption) {
                $serviceOption->delete();
            }
            $plan->tvService->delete();
        }

        $plan->delete();

        return redirect()->route('plans.dashboard')->with('success', 'Plan deleted successfully.');
    }
}
