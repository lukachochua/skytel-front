<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\PlanController;
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

Route::resource('plans', PlanController::class);



// Auth Routes
Auth::routes();

// Admin Routes (requires authentication)
Route::middleware(['auth'])->prefix('home')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::resource('sliders', SliderController::class)->except('show');
    Route::resource('news', NewsController::class)->except('index', 'show');
    Route::get('news', [HomeController::class, 'news'])->name('news.dashboard');
});
