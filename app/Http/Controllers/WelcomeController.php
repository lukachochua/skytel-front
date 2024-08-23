<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Slider;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function welcome()
    {
        $latestNews = News::latest()->take(3)->get();
        $sliders = Slider::all();
        return view('welcome', compact('latestNews', 'sliders'));
    }
}