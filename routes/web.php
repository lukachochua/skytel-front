<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

Route::get('/set-locale/{locale}', function ($locale) {
    Session::put('locale', $locale);
    app()->setLocale($locale);
    return redirect()->back();
})->name('change-locale');

Route::get('/', [WelcomeController::class, 'welcome'])->name('welcome');

Route::get('/features', function () {
    return view('features');
});


Route::get('news', [NewsController::class, 'index'])->name('news.index');
Route::get('news/{id}/', [NewsController::class, 'show'])->name('news.show');

Route::resource('/home/news', NewsController::class)->except('index', 'show');

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/home/news', [HomeController::class, 'news'])->name('news.dashboard');


Auth::routes();