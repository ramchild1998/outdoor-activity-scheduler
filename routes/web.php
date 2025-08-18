<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\WeatherController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/activities', [ActivityController::class, 'index'])->name('activities.index');
Route::post('/activities', [ActivityController::class, 'store'])->name('activities.store');
Route::get('/activities/create', [ActivityController::class, 'create'])->name('activities.create');
Route::get('/activities/{activity}', [ActivityController::class, 'show'])->name('activities.show');

Route::get('/weather/forecast', [WeatherController::class, 'getForecast'])->name('weather.forecast');
Route::get('/weather/suggestions', [WeatherController::class, 'getSuggestions'])->name('weather.suggestions');