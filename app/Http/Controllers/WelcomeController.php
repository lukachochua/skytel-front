<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Plan;
use App\Models\PlanType;
use App\Models\Slider;
use App\View\Components\plans;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function welcome()
    {
        $latestNews = News::latest()->get();
        $sliders = Slider::all();
        $plans = Plan::all();
        $fiberOpticType = PlanType::where('name', 'Fiber Optic')->first();

        return view('welcome', compact('latestNews', 'sliders', 'plans', 'fiberOpticType'));
    }
}
