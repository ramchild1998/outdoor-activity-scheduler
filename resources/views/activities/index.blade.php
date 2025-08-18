@extends('layouts.app')

@section('title', 'Activities')

@section('content')
<div class="row">
    <div class="col-12">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>
                <i class="fas fa-calendar-alt me-2"></i>
                Activities
            </h2>
            <a href="{{ route('activities.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>
                New Activity
            </a>
        </div>

        <!-- Filters -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('activities.index') }}" class="row g-3">
                    <div class="col-md-3">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" class="form-control" id="date" name="date" value="{{ request('date') }}">
                    </div>
                    <div class="col-md-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="">All Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="location" class="form-label">Location</label>
                        <input type="text" class="form-control" id="location" name="location" 
                               value="{{ request('location') }}" placeholder="Search by location...">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-outline-primary">
                                <i class="fas fa-search me-1"></i>
                                Filter
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Activities List -->
        @if($activities->count() > 0)
            <div class="row">
                @foreach($activities as $activity)
                <div class="col-lg-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <h5 class="card-title mb-0">{{ $activity->name }}</h5>
                                <span class="activity-status status-{{ $activity->status }}">
                                    {{ ucfirst($activity->status) }}
                                </span>
                            </div>
                            
                            <div class="mb-3">
                                <p class="card-text mb-2">
                                    <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                    <strong>{{ $activity->location }}</strong>
                                    @if($activity->sub_district)
                                        <br>
                                        <small class="text-muted ms-4">{{ $activity->sub_district }}</small>
                                        @if($activity->village)
                                            <small class="text-muted">, {{ $activity->village }}</small>
                                        @endif
                                    @endif
                                </p>
                                
                                <p class="card-text mb-2">
                                    <i class="fas fa-calendar text-info me-2"></i>
                                    {{ $activity->formatted_date }}
                                    @if($activity->selected_time_slot)
                                        <i class="fas fa-clock text-warning ms-3 me-1"></i>
                                        {{ $activity->formatted_time_slot }}
                                    @endif
                                </p>
                                
                                @if($activity->weather_condition)
                                <p class="card-text mb-2">
                                    <i class="fas fa-cloud text-secondary me-2"></i>
                                    {{ $activity->weather_condition }}
                                </p>
                                @endif
                                
                                @if($activity->notes)
                                <p class="card-text">
                                    <i class="fas fa-sticky-note text-muted me-2"></i>
                                    <small class="text-muted">{{ Str::limit($activity->notes, 100) }}</small>
                                </p>
                                @endif
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <i class="fas fa-clock me-1"></i>
                                    Created {{ $activity->created_at->diffForHumans() }}
                                </small>
                                
                                <div class="btn-group" role="group">
                                    <a href="{{ route('activities.show', $activity) }}" 
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye me-1"></i>
                                        View
                                    </a>
                                    @if($activity->status === 'pending')
                                    <button type="button" 
                                            class="btn btn-sm btn-outline-success schedule-btn"
                                            data-activity-id="{{ $activity->id }}"
                                            data-activity-name="{{ $activity->name }}">
                                        <i class="fas fa-calendar-check me-1"></i>
                                        Schedule
                                    </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        @if($activity->isPast() && $activity->status !== 'completed')
                        <div class="card-footer bg-warning bg-opacity-10">
                            <small class="text-warning">
                                <i class="fas fa-exclamation-triangle me-1"></i>
                                This activity date has passed
                            </small>
                        </div>
                        @elseif($activity->isToday())
                        <div class="card-footer bg-info bg-opacity-10">
                            <small class="text-info">
                                <i class="fas fa-calendar-day me-1"></i>
                                Scheduled for today
                            </small>
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $activities->appends(request()->query())->links() }}
            </div>
        @else
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="fas fa-calendar-times text-muted" style="font-size: 4rem;"></i>
                    <h4 class="mt-3 mb-3">No Activities Found</h4>
                    <p class="text-muted mb-4">
                        @if(request()->hasAny(['date', 'status', 'location']))
                            No activities match your current filters. Try adjusting your search criteria.
                        @else
                            You haven't created any activities yet. Start by scheduling your first outdoor activity!
                        @endif
                    </p>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                        @if(request()->hasAny(['date', 'status', 'location']))
                            <a href="{{ route('activities.index') }}" class="btn btn-outline-secondary me-md-2">
                                <i class="fas fa-times me-1"></i>
                                Clear Filters
                            </a>
                        @endif
                        <a href="{{ route('activities.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i>
                            Create First Activity
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Schedule Modal -->
<div class="modal fade" id="scheduleModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-calendar-check me-2"></i>
                    Schedule Activity
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to mark this activity as scheduled?</p>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong id="activityName"></strong> will be marked as scheduled and ready for execution.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="confirmSchedule">
                    <i class="fas fa-check me-1"></i>
                    Confirm Schedule
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    let currentActivityId = null;
    
    // Handle schedule button click
    $('.schedule-btn').click(function() {
        currentActivityId = $(this).data('activity-id');
        const activityName = $(this).data('activity-name');
        
        $('#activityName').text(activityName);
        $('#scheduleModal').modal('show');
    });
    
    // Handle schedule confirmation
    $('#confirmSchedule').click(function() {
        if (!currentActivityId) return;
        
        const button = $(this);
        const originalText = button.html();
        
        button.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i>Scheduling...');
        
        $.ajax({
            url: `/api/activities/${currentActivityId}`,
            method: 'PUT',
            data: {
                status: 'scheduled'
            },
            success: function(response) {
                if (response.success) {
                    $('#scheduleModal').modal('hide');
                    location.reload(); // Reload to show updated status
                } else {
                    alert('Failed to schedule activity. Please try again.');
                }
            },
            error: function(xhr, status, error) {
                alert('Failed to schedule activity. Please try again.');
            },
            complete: function() {
                button.prop('disabled', false).html(originalText);
            }
        });
    });
    
    // Auto-submit form when filters change (optional)
    $('#date, #status').change(function() {
        // Uncomment the line below to auto-submit on filter change
        // $(this).closest('form').submit();
    });
});
</script>
@endpush