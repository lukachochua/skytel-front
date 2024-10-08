<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Plan;
use App\Models\PlanOption;
use App\Models\PlanType;
use App\Models\TvService;
use App\Models\TvServiceOption;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function news()
    {
        $news = News::latest()->paginate(9);

        return view('admin.news.dashboard', compact('news'));
    }

}
