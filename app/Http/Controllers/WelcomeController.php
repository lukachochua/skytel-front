<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function welcome()
    {
        $latestNews = News::latest()->take(3)->get();
        return view('welcome', compact('latestNews'));
    }
}