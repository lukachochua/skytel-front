<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\PlanOptionController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

// Locale Change Route
Route::get('/set-locale/{locale}', function ($locale) {
    Session::put('locale', $locale);
    app()->setLocale($locale);
    return redirect()->back();
})->name('change-locale');

// Public Routes
Route::get('/', [WelcomeController::class, 'welcome'])->name('welcome');
Route::get('/features', function () {
    return view('features');
})->name('features');
Route::get('news', [NewsController::class, 'index'])->name('news.index');
Route::get('news/{id}/', [NewsController::class, 'show'])->name('news.show');
Route::get('sliders/{id}/', [SliderController::class, 'show'])->name('sliders.show');
Route::get('plans', [PlanController::class, 'index'])->name('plans.index');
Route::get('plans/{plan}', [PlanController::class, 'show'])->name('plans.show');


// Auth Routes
Auth::routes();

// Admin Routes (requires authentication)
Route::middleware(['auth'])->prefix('home')->group(function () {
    Route::resource('sliders', SliderController::class)->except('show');
    Route::resource('news', NewsController::class)->except('index', 'show');
    Route::resource('plans', PlanController::class)->except('index', 'show');
    Route::resource('planOptions', PlanOptionController::class);
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/news', [HomeController::class, 'news'])->name('news.dashboard');
    Route::get('/plans', [HomeController::class, 'plans'])->name('plans.dashboard');
});
