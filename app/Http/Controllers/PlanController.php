<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\PlanType;
use App\Models\TvOption;
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

        return view('admin.plans.create', compact('tvServices', 'tvServiceOptions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:fiber_optic,wireless,tv,corporate',
            'description' => 'nullable|string',
            'status' => 'required|string|in:active,inactive',
            'tv_service' => 'required_if:type,fiber_optic|string|max:255',
            'tv_service_option' => 'required_if:type,fiber_optic|string|max:255',
        ]);

        $plan = Plan::create([
            'name' => $request->input('name'),
            'type' => $request->input('type'),
            'description' => $request->input('description'),
            'status' => $request->input('status'),
        ]);

        if ($request->input('type') === 'fiber_optic') {
            // Handle TV service and options
            $tvService = $request->input('tv_service');
            $tvServiceOption = $request->input('tv_service_option');

            // Add TV service and options logic here, assuming you have relationships set up
            $plan->tvServices()->create([
                'service_name' => $tvService,
                'options' => [
                    [
                        'option_name' => $tvServiceOption,
                        'additional_price' => 0, // Default value or retrieve from input if available
                    ]
                ]
            ]);
        }

        return redirect()->route('plans.index')
            ->with('success', __('plans.plan_created_successfully'));
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
}
