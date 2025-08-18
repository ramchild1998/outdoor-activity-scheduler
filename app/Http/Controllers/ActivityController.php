<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Services\WeatherService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

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
                           ->paginate(10);

        return view('activities.index', compact('activities'));
    }

    /**
     * Show the form for creating a new activity
     */
    public function create()
    {
        $locations = $this->weatherService->getAvailableLocations();
        return view('activities.create', compact('locations'));
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
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }
            
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        $activity = Activity::create($request->all());

        // Get weather suggestions for the activity
        $suggestions = $this->weatherService->getSuggestions(
            $request->location,
            $request->preferred_date
        );

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'activity' => $activity,
                'weather_suggestions' => $suggestions
            ], 201);
        }

        return redirect()->route('activities.show', $activity)
                        ->with('success', 'Activity created successfully!')
                        ->with('weather_suggestions', $suggestions);
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

        return view('activities.show', compact('activity', 'suggestions'));
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
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }
            
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        $activity->update($request->all());

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'activity' => $activity
            ]);
        }

        return redirect()->route('activities.show', $activity)
                        ->with('success', 'Activity updated successfully!');
    }

    /**
     * Remove the specified activity
     */
    public function destroy(Activity $activity)
    {
        $activity->delete();

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Activity deleted successfully!'
            ]);
        }

        return redirect()->route('activities.index')
                        ->with('success', 'Activity deleted successfully!');
    }

    /**
     * Get weather suggestions for activity planning
     */
    public function getWeatherSuggestions(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'location' => 'required|string',
            'date' => 'required|date|after_or_equal:today'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $suggestions = $this->weatherService->getSuggestions(
            $request->location,
            $request->date
        );

        return response()->json([
            'success' => true,
            'suggestions' => $suggestions
        ]);
    }
}