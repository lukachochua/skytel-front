<?php

use App\Http\Controllers\NewsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/features', function () {
    return view('features');
});

Route::resource('news', NewsController::class);
