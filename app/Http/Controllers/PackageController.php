<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\TVPlan;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::with('tvPlan')->get();
        return view('admin.packages.index', compact('packages'));
    }

    public function create()
    {
        $tvPlans = TVPlan::all();
        return view('admin.packages.create', compact('tvPlans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tv_plan_id' => 'required|exists:tv_plans,id',
            'name' => 'required',
            'price' => 'required|numeric'
        ]);

        Package::create($request->all());
        return redirect()->route('admin.packages.index');
    }

    public function edit(Package $package)
    {
        $tvPlans = TVPlan::all();
        return view('admin.packages.edit', compact('package', 'tvPlans'));
    }

    public function update(Request $request, Package $package)
    {
        $request->validate([
            'tv_plan_id' => 'required|exists:tv_plans,id',
            'name' => 'required',
            'price' => 'required|numeric'
        ]);

        $package->update($request->all());
        return redirect()->route('admin.packages.index');
    }

    public function destroy(Package $package)
    {
        $package->delete();
        return redirect()->route('admin.packages.index');
    }
}
