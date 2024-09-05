<?php

namespace App\Http\Controllers;

use App\Models\TvPlan;
use App\Models\Package;
use Illuminate\Http\Request;

class TvPlanController extends Controller
{
    public function show(TvPlan $tvPlan)
    {
        $packages = $tvPlan->packages;
        return view('tv_plans.show', compact('tvPlan', 'packages'));
    }
}
