<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Services\WeatherService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ActivityController extends Controller
{
    protected $weatherService;

    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    /**
     * Display a listing of activities
     */
    public function index(Request $request)
    {
        $query = Activity::query();

        // Filter by date if provided
        if ($request->has('date')) {
            $query->forDate($request->date);
        }

        // Filter by status if provided
        if ($request->has('status')) {
            $query->byStatus($request->status);
        }

        // Filter by location if provided
        if ($request->has('location')) {
            $query->byLocation($request->location);
        }

        $activities = $query->orderBy('preferred_date', 'desc')
                           ->orderBy('created_at', 'desc')
                           ->paginate($request->get('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => $activities->items(),
            'pagination' => [
                'current_page' => $activities->currentPage(),
                'last_page' => $activities->lastPage(),
                'per_page' => $activities->perPage(),
                'total' => $activities->total(),
                'from' => $activities->firstItem(),
                'to' => $activities->lastItem()
            ]
        ]);
    }

    /**
     * Store a newly created activity
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'sub_district' => 'nullable|string|max:255',
            'village' => 'nullable|string|max:255',
            'preferred_date' => 'required|date|after_or_equal:today',
            'selected_time_slot' => 'nullable|date_format:Y-m-d H:i',
            'notes' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $activity = Activity::create($request->all());

        // Get weather suggestions for the activity
        $suggestions = $this->weatherService->getSuggestions(
            $request->location,
            $request->preferred_date
        );

        return response()->json([
            'success' => true,
            'message' => 'Activity created successfully',
            'data' => $activity,
            'weather_suggestions' => $suggestions
        ], 201);
    }

    /**
     * Display the specified activity
     */
    public function show(Activity $activity)
    {
        // Get weather suggestions for this activity
        $suggestions = $this->weatherService->getSuggestions(
            $activity->location,
            $activity->preferred_date->format('Y-m-d')
        );

        return response()->json([
            'success' => true,
            'data' => $activity,
            'weather_suggestions' => $suggestions
        ]);
    }

    /**
     * Update the specified activity
     */
    public function update(Request $request, Activity $activity)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'location' => 'sometimes|required|string|max:255',
            'sub_district' => 'nullable|string|max:255',
            'village' => 'nullable|string|max:255',
            'preferred_date' => 'sometimes|required|date|after_or_equal:today',
            'selected_time_slot' => 'nullable|date_format:Y-m-d H:i',
            'weather_condition' => 'nullable|string|max:255',
            'status' => 'sometimes|required|in:pending,scheduled,completed,cancelled',
            'notes' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $activity->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Activity updated successfully',
            'data' => $activity
        ]);
    }

    /**
     * Remove the specified activity
     */
    public function destroy(Activity $activity)
    {
        $activity->delete();

        return response()->json([
            'success' => true,
            'message' => 'Activity deleted successfully'
        ]);
    }
}