<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\PlanController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\TvPlanController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\TeamMemberController;
use App\Models\TeamMember;

// Locale Change Route
Route::get('/set-locale/{locale}', function ($locale) {
    Session::put('locale', $locale);
    app()->setLocale($locale);
    return redirect()->back();
})->name('change-locale');

// Public Routes
Route::get('/', [WelcomeController::class, 'welcome'])->name('welcome');
Route::get('news', [NewsController::class, 'index'])->name('news.index');
Route::get('news/{id}/', [NewsController::class, 'show'])->name('news.show');
Route::get('sliders/{id}/', [SliderController::class, 'show'])->name('sliders.show');
Route::get('about', function () {
    $teamMembers = TeamMember::all();
    return view('about.index', compact('teamMembers'));
})->name('about.index');

// Public Routes for Plans and packages
Route::get('/plans', [PlanController::class, 'index'])->name('plans.index');
Route::get('/plans/{id}', [PlanController::class, 'show'])->name('plans.show');
Route::delete('/packages/{id}', [PlanController::class, 'deletePackage'])->name('packages.delete');
Route::post('/plans/{plan}/store-selection', [PlanController::class, 'storeSelection'])->name('plans.storeSelection');


// Auth Routes
Auth::routes();

// Admin Routes (requires authentication)
Route::middleware(['auth'])->prefix('home')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::resource('sliders', SliderController::class)->except('show');
    Route::resource('news', NewsController::class)->except('index', 'show');
    Route::get('news', [HomeController::class, 'news'])->name('news.dashboard');

    Route::resource('plans', PlanController::class)->except('show');
    Route::get('plans', [PlanController::class, 'dashboard'])->name('plans.dashboard');

    Route::resource('tvplans', TvPlanController::class)->except('show');
    Route::resource('packages', PackageController::class)->except('show');

    Route::resource('team', TeamMemberController::class);

    Route::resource('links', LinkController::class);
});
