<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\WeatherService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WeatherController extends Controller
{
    protected $weatherService;

    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    /**
     * Get weather forecast for a location
     */
    public function getForecast(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'province_id' => 'required|string',
            'days' => 'nullable|integer|min:1|max:7'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $forecast = $this->weatherService->getForecast(
            $request->province_id,
            $request->get('days', 3)
        );

        return response()->json([
            'success' => true,
            'message' => 'Weather forecast retrieved successfully',
            'data' => [
                'province_id' => $request->province_id,
                'days' => $request->get('days', 3),
                'forecast' => $forecast
            ]
        ]);
    }

    /**
     * Get weather suggestions for optimal time slots
     */
    public function getSuggestions(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'location' => 'required|string',
            'date' => 'required|date|after_or_equal:today',
            'province_id' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $suggestions = $this->weatherService->getSuggestions(
            $request->location,
            $request->date,
            $request->get('province_id', '31') // Default to Jakarta
        );

        return response()->json([
            'success' => true,
            'message' => 'Weather suggestions retrieved successfully',
            'data' => [
                'location' => $request->location,
                'date' => $request->date,
                'province_id' => $request->get('province_id', '31'),
                'suggestions' => $suggestions,
                'optimal_count' => collect($suggestions)->where('is_optimal', true)->count(),
                'total_slots' => count($suggestions)
            ]
        ]);
    }

    /**
     * Get available locations/provinces
     */
    public function getLocations()
    {
        $locations = $this->weatherService->getAvailableLocations();

        return response()->json([
            'success' => true,
            'message' => 'Available locations retrieved successfully',
            'data' => [
                'locations' => $locations,
                'total' => count($locations)
            ]
        ]);
    }
}