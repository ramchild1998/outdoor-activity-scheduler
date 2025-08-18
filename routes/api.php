<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ActivityController;
use App\Http\Controllers\Api\WeatherController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Activity API routes
Route::prefix('activities')->group(function () {
    Route::get('/', [ActivityController::class, 'index']);
    Route::post('/', [ActivityController::class, 'store']);
    Route::get('/{activity}', [ActivityController::class, 'show']);
    Route::put('/{activity}', [ActivityController::class, 'update']);
    Route::delete('/{activity}', [ActivityController::class, 'destroy']);
});

// Weather API routes
Route::prefix('weather')->group(function () {
    Route::get('/forecast', [WeatherController::class, 'getForecast']);
    Route::get('/suggestions', [WeatherController::class, 'getSuggestions']);
    Route::get('/locations', [WeatherController::class, 'getLocations']);
});