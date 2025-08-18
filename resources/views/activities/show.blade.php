@extends('layouts.app')

@section('title', $activity->name)

@section('content')
<div class="row">
    <div class="col-lg-8">
        <!-- Activity Details -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">
                    <i class="fas fa-eye me-2"></i>
                    Activity Details
                </h4>
                <span class="activity-status status-{{ $activity->status }}">
                    {{ ucfirst($activity->status) }}
                </span>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="text-primary">{{ $activity->name }}</h5>
                        
                        <div class="mb-3">
                            <h6 class="text-muted mb-2">
                                <i class="fas fa-map-marker-alt me-1"></i>
                                Location
                            </h6>
                            <p class="mb-1"><strong>{{ $activity->location }}</strong></p>
                            @if($activity->sub_district)
                                <p class="mb-1 text-muted">Sub-District: {{ $activity->sub_district }}</p>
                            @endif
                            @if($activity->village)
                                <p class="mb-0 text-muted">Village: {{ $activity->village }}</p>
                            @endif
                        </div>
                        
                        <div class="mb-3">
                            <h6 class="text-muted mb-2">
                                <i class="fas fa-calendar me-1"></i>
                                Schedule
                            </h6>
                            <p class="mb-1">
                                <strong>Preferred Date:</strong> {{ $activity->formatted_date }}
                            </p>
                            @if($activity->selected_time_slot)
                                <p class="mb-0">
                                    <strong>Selected Time:</strong> {{ $activity->selected_time_slot->format('H:i') }}
                                </p>
                            @else
                                <p class="mb-0 text-muted">No specific time selected</p>
                            @endif
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        @if($activity->weather_condition)
                        <div class="mb-3">
                            <h6 class="text-muted mb-2">
                                <i class="fas fa-cloud me-1"></i>
                                Weather Condition
                            </h6>
                            <p class="mb-0">{{ $activity->weather_condition }}</p>
                        </div>
                        @endif
                        
                        <div class="mb-3">
                            <h6 class="text-muted mb-2">
                                <i class="fas fa-info-circle me-1"></i>
                                Activity Status
                            </h6>
                            <div class="d-flex align-items-center">
                                <span class="activity-status status-{{ $activity->status }} me-2">
                                    {{ ucfirst($activity->status) }}
                                </span>
                                @if($activity->status === 'pending')
                                    <button type="button" class="btn btn-sm btn-success" id="scheduleBtn">
                                        <i class="fas fa-calendar-check me-1"></i>
                                        Mark as Scheduled
                                    </button>
                                @elseif($activity->status === 'scheduled')
                                    <button type="button" class="btn btn-sm btn-primary" id="completeBtn">
                                        <i class="fas fa-check-circle me-1"></i>
                                        Mark as Completed
                                    </button>
                                @endif
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <h6 class="text-muted mb-2">
                                <i class="fas fa-clock me-1"></i>
                                Timeline
                            </h6>
                            <small class="text-muted">
                                Created: {{ $activity->created_at->format('d M Y, H:i') }}<br>
                                Updated: {{ $activity->updated_at->format('d M Y, H:i') }}
                            </small>
                        </div>
                    </div>
                </div>
                
                @if($activity->notes)
                <div class="mt-4">
                    <h6 class="text-muted mb-2">
                        <i class="fas fa-sticky-note me-1"></i>
                        Notes
                    </h6>
                    <div class="bg-light p-3 rounded">
                        {{ $activity->notes }}
                    </div>
                </div>
                @endif
                
                <div class="mt-4 d-flex justify-content-between">
                    <a href="{{ route('activities.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i>
                        Back to Activities
                    </a>
                    
                    <div>
                        <button type="button" class="btn btn-outline-info me-2" id="refreshWeatherBtn">
                            <i class="fas fa-sync me-1"></i>
                            Refresh Weather
                        </button>
                        <button type="button" class="btn btn-outline-danger" id="deleteBtn">
                            <i class="fas fa-trash me-1"></i>
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <!-- Weather Suggestions -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-cloud-sun me-2"></i>
                    Weather Forecast
                </h5>
            </div>
            <div class="card-body" id="weatherContent">
                @if(isset($suggestions) && count($suggestions) > 0)
                    @foreach($suggestions as $suggestion)
                    <div class="weather-card {{ $suggestion['is_optimal'] ? 'optimal' : 'not-optimal' }} mb-3">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1">
                                        <i class="fas fa-clock me-1"></i>
                                        {{ $suggestion['time'] }}
                                    </h6>
                                    <p class="mb-1">
                                        <i class="fas fa-cloud me-1"></i>
                                        {{ $suggestion['weather'] }}
                                    </p>
                                    <small class="text-muted">
                                        <i class="fas fa-thermometer-half me-1"></i>
                                        {{ $suggestion['temperature'] }}°C
                                        <i class="fas fa-tint ms-2 me-1"></i>
                                        {{ $suggestion['humidity'] }}%
                                    </small>
                                </div>
                                <div class="text-end">
                                    @if($suggestion['is_optimal'])
                                        <i class="fas fa-check-circle text-success" style="font-size: 1.2rem;"></i>
                                        <br>
                                        <small class="text-success fw-bold">Optimal</small>
                                    @else
                                        <i class="fas fa-times-circle text-danger" style="font-size: 1.2rem;"></i>
                                        <br>
                                        <small class="text-danger fw-bold">Not Ideal</small>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    
                    <div class="text-center mt-3">
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            Weather data from BMKG
                        </small>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-cloud-meatball text-muted" style="font-size: 2rem;"></i>
                        <p class="mt-2 mb-0 text-muted">No weather data available</p>
                        <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="loadWeatherBtn">
                            <i class="fas fa-sync me-1"></i>
                            Load Weather Data
                        </button>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="card mt-4">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="fas fa-bolt me-2"></i>
                    Quick Actions
                </h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    @if($activity->status === 'pending')
                        <button type="button" class="btn btn-success btn-sm" onclick="updateStatus('scheduled')">
                            <i class="fas fa-calendar-check me-1"></i>
                            Schedule Activity
                        </button>
                    @elseif($activity->status === 'scheduled')
                        <button type="button" class="btn btn-primary btn-sm" onclick="updateStatus('completed')">
                            <i class="fas fa-check-circle me-1"></i>
                            Mark Completed
                        </button>
                        <button type="button" class="btn btn-warning btn-sm" onclick="updateStatus('cancelled')">
                            <i class="fas fa-times-circle me-1"></i>
                            Cancel Activity
                        </button>
                    @endif
                    
                    <button type="button" class="btn btn-info btn-sm" onclick="shareActivity()">
                        <i class="fas fa-share me-1"></i>
                        Share Activity
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Delete Activity
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this activity?</p>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>{{ $activity->name }}</strong> will be permanently deleted. This action cannot be undone.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">
                    <i class="fas fa-trash me-1"></i>
                    Delete Activity
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Delete button handler
    $('#deleteBtn').click(function() {
        $('#deleteModal').modal('show');
    });
    
    // Confirm delete handler
    $('#confirmDelete').click(function() {
        const button = $(this);
        const originalText = button.html();
        
        button.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i>Deleting...');
        
        $.ajax({
            url: `/api/activities/{{ $activity->id }}`,
            method: 'DELETE',
            success: function(response) {
                if (response.success) {
                    window.location.href = '{{ route("activities.index") }}';
                } else {
                    alert('Failed to delete activity. Please try again.');
                }
            },
            error: function(xhr, status, error) {
                alert('Failed to delete activity. Please try again.');
            },
            complete: function() {
                button.prop('disabled', false).html(originalText);
            }
        });
    });
    
    // Refresh weather button handler
    $('#refreshWeatherBtn, #loadWeatherBtn').click(function() {
        loadWeatherData();
    });
    
    function loadWeatherData() {
        $('#weatherContent').html(`
            <div class="text-center py-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2">Loading weather data...</p>
            </div>
        `);
        
        $.ajax({
            url: '/api/weather/suggestions',
            method: 'GET',
            data: {
                location: '{{ $activity->location }}',
                date: '{{ $activity->preferred_date->format("Y-m-d") }}'
            },
            success: function(response) {
                if (response.success && response.data.suggestions.length > 0) {
                    displayWeatherData(response.data.suggestions);
                } else {
                    $('#weatherContent').html(`
                        <div class="text-center py-4">
                            <i class="fas fa-exclamation-triangle text-warning" style="font-size: 2rem;"></i>
                            <p class="mt-2 mb-0 text-muted">No weather data available</p>
                        </div>
                    `);
                }
            },
            error: function(xhr, status, error) {
                $('#weatherContent').html(`
                    <div class="text-center py-4">
                        <i class="fas fa-exclamation-circle text-danger" style="font-size: 2rem;"></i>
                        <p class="mt-2 mb-0 text-muted">Failed to load weather data</p>
                        <button type="button" class="btn btn-sm btn-outline-primary mt-2" onclick="loadWeatherData()">
                            <i class="fas fa-retry me-1"></i>
                            Try Again
                        </button>
                    </div>
                `);
            }
        });
    }
    
    function displayWeatherData(suggestions) {
        let html = '';
        
        suggestions.forEach(function(suggestion) {
            const cardClass = suggestion.is_optimal ? 'optimal' : 'not-optimal';
            const iconClass = suggestion.is_optimal ? 'fa-check-circle text-success' : 'fa-times-circle text-danger';
            const statusText = suggestion.is_optimal ? 'Optimal' : 'Not Ideal';
            const statusClass = suggestion.is_optimal ? 'text-success' : 'text-danger';
            
            html += `
                <div class="weather-card ${cardClass} mb-3">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="mb-1">
                                    <i class="fas fa-clock me-1"></i>
                                    ${suggestion.time}
                                </h6>
                                <p class="mb-1">
                                    <i class="fas fa-cloud me-1"></i>
                                    ${suggestion.weather}
                                </p>
                                <small class="text-muted">
                                    <i class="fas fa-thermometer-half me-1"></i>
                                    ${suggestion.temperature}°C
                                    <i class="fas fa-tint ms-2 me-1"></i>
                                    ${suggestion.humidity}%
                                </small>
                            </div>
                            <div class="text-end">
                                <i class="fas ${iconClass}" style="font-size: 1.2rem;"></i>
                                <br>
                                <small class="${statusClass} fw-bold">${statusText}</small>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        });
        
        html += `
            <div class="text-center mt-3">
                <small class="text-muted">
                    <i class="fas fa-info-circle me-1"></i>
                    Weather data from BMKG
                </small>
            </div>
        `;
        
        $('#weatherContent').html(html);
    }
});

// Update activity status
function updateStatus(status) {
    if (!confirm(`Are you sure you want to mark this activity as ${status}?`)) {
        return;
    }
    
    $.ajax({
        url: `/api/activities/{{ $activity->id }}`,
        method: 'PUT',
        data: { status: status },
        success: function(response) {
            if (response.success) {
                location.reload();
            } else {
                alert('Failed to update activity status. Please try again.');
            }
        },
        error: function(xhr, status, error) {
            alert('Failed to update activity status. Please try again.');
        }
    });
}

// Share activity
function shareActivity() {
    const shareText = `Activity: {{ $activity->name }}\nLocation: {{ $activity->location }}\nDate: {{ $activity->formatted_date }}`;
    
    if (navigator.share) {
        navigator.share({
            title: '{{ $activity->name }}',
            text: shareText,
            url: window.location.href
        });
    } else {
        // Fallback: copy to clipboard
        navigator.clipboard.writeText(shareText).then(function() {
            alert('Activity details copied to clipboard!');
        });
    }
}
</script>
@endpush