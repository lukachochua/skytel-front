<?php

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

Route::resource('news', NewsController::class);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
