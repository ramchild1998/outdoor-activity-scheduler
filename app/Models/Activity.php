<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
        'sub_district',
        'village',
        'preferred_date',
        'selected_time_slot',
        'weather_condition',
        'status',
        'notes'
    ];

    protected $casts = [
        'preferred_date' => 'date',
        'selected_time_slot' => 'datetime',
    ];

    /**
     * Get activities for a specific date
     */
    public function scopeForDate($query, $date)
    {
        return $query->whereDate('preferred_date', $date);
    }

    /**
     * Get activities by status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Get activities by location
     */
    public function scopeByLocation($query, $location)
    {
        return $query->where('location', 'like', "%{$location}%");
    }

    /**
     * Check if activity is scheduled for today
     */
    public function isToday()
    {
        return $this->preferred_date->isToday();
    }

    /**
     * Check if activity is in the past
     */
    public function isPast()
    {
        return $this->preferred_date->isPast();
    }

    /**
     * Get formatted date
     */
    public function getFormattedDateAttribute()
    {
        return $this->preferred_date->format('d M Y');
    }

    /**
     * Get formatted time slot
     */
    public function getFormattedTimeSlotAttribute()
    {
        return $this->selected_time_slot ? $this->selected_time_slot->format('H:i') : null;
    }
}