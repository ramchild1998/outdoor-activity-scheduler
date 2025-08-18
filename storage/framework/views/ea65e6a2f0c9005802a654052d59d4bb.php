

<?php $__env->startSection('title', $activity->name); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-lg-8">
        <!-- Activity Details -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">
                    <i class="fas fa-eye me-2"></i>
                    Activity Details
                </h4>
                <span class="activity-status status-<?php echo e($activity->status); ?>">
                    <?php echo e(ucfirst($activity->status)); ?>

                </span>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="text-primary"><?php echo e($activity->name); ?></h5>
                        
                        <div class="mb-3">
                            <h6 class="text-muted mb-2">
                                <i class="fas fa-map-marker-alt me-1"></i>
                                Location
                            </h6>
                            <p class="mb-1"><strong><?php echo e($activity->location); ?></strong></p>
                            <?php if($activity->sub_district): ?>
                                <p class="mb-1 text-muted">Sub-District: <?php echo e($activity->sub_district); ?></p>
                            <?php endif; ?>
                            <?php if($activity->village): ?>
                                <p class="mb-0 text-muted">Village: <?php echo e($activity->village); ?></p>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mb-3">
                            <h6 class="text-muted mb-2">
                                <i class="fas fa-calendar me-1"></i>
                                Schedule
                            </h6>
                            <p class="mb-1">
                                <strong>Preferred Date:</strong> <?php echo e($activity->formatted_date); ?>

                            </p>
                            <?php if($activity->selected_time_slot): ?>
                                <p class="mb-0">
                                    <strong>Selected Time:</strong> <?php echo e($activity->selected_time_slot->format('H:i')); ?>

                                </p>
                            <?php else: ?>
                                <p class="mb-0 text-muted">No specific time selected</p>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <?php if($activity->weather_condition): ?>
                        <div class="mb-3">
                            <h6 class="text-muted mb-2">
                                <i class="fas fa-cloud me-1"></i>
                                Weather Condition
                            </h6>
                            <p class="mb-0"><?php echo e($activity->weather_condition); ?></p>
                        </div>
                        <?php endif; ?>
                        
                        <div class="mb-3">
                            <h6 class="text-muted mb-2">
                                <i class="fas fa-info-circle me-1"></i>
                                Activity Status
                            </h6>
                            <div class="d-flex align-items-center">
                                <span class="activity-status status-<?php echo e($activity->status); ?> me-2">
                                    <?php echo e(ucfirst($activity->status)); ?>

                                </span>
                                <?php if($activity->status === 'pending'): ?>
                                    <button type="button" class="btn btn-sm btn-success" id="scheduleBtn">
                                        <i class="fas fa-calendar-check me-1"></i>
                                        Mark as Scheduled
                                    </button>
                                <?php elseif($activity->status === 'scheduled'): ?>
                                    <button type="button" class="btn btn-sm btn-primary" id="completeBtn">
                                        <i class="fas fa-check-circle me-1"></i>
                                        Mark as Completed
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <h6 class="text-muted mb-2">
                                <i class="fas fa-clock me-1"></i>
                                Timeline
                            </h6>
                            <small class="text-muted">
                                Created: <?php echo e($activity->created_at->format('d M Y, H:i')); ?><br>
                                Updated: <?php echo e($activity->updated_at->format('d M Y, H:i')); ?>

                            </small>
                        </div>
                    </div>
                </div>
                
                <?php if($activity->notes): ?>
                <div class="mt-4">
                    <h6 class="text-muted mb-2">
                        <i class="fas fa-sticky-note me-1"></i>
                        Notes
                    </h6>
                    <div class="bg-light p-3 rounded">
                        <?php echo e($activity->notes); ?>

                    </div>
                </div>
                <?php endif; ?>
                
                <div class="mt-4 d-flex justify-content-between">
                    <a href="<?php echo e(route('activities.index')); ?>" class="btn btn-secondary">
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
                <?php if(isset($suggestions) && count($suggestions) > 0): ?>
                    <?php $__currentLoopData = $suggestions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $suggestion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="weather-card <?php echo e($suggestion['is_optimal'] ? 'optimal' : 'not-optimal'); ?> mb-3">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1">
                                        <i class="fas fa-clock me-1"></i>
                                        <?php echo e($suggestion['time']); ?>

                                    </h6>
                                    <p class="mb-1">
                                        <i class="fas fa-cloud me-1"></i>
                                        <?php echo e($suggestion['weather']); ?>

                                    </p>
                                    <small class="text-muted">
                                        <i class="fas fa-thermometer-half me-1"></i>
                                        <?php echo e($suggestion['temperature']); ?>°C
                                        <i class="fas fa-tint ms-2 me-1"></i>
                                        <?php echo e($suggestion['humidity']); ?>%
                                    </small>
                                </div>
                                <div class="text-end">
                                    <?php if($suggestion['is_optimal']): ?>
                                        <i class="fas fa-check-circle text-success" style="font-size: 1.2rem;"></i>
                                        <br>
                                        <small class="text-success fw-bold">Optimal</small>
                                    <?php else: ?>
                                        <i class="fas fa-times-circle text-danger" style="font-size: 1.2rem;"></i>
                                        <br>
                                        <small class="text-danger fw-bold">Not Ideal</small>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    
                    <div class="text-center mt-3">
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            Weather data from BMKG
                        </small>
                    </div>
                <?php else: ?>
                    <div class="text-center py-4">
                        <i class="fas fa-cloud-meatball text-muted" style="font-size: 2rem;"></i>
                        <p class="mt-2 mb-0 text-muted">No weather data available</p>
                        <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="loadWeatherBtn">
                            <i class="fas fa-sync me-1"></i>
                            Load Weather Data
                        </button>
                    </div>
                <?php endif; ?>
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
                    <?php if($activity->status === 'pending'): ?>
                        <button type="button" class="btn btn-success btn-sm" onclick="updateStatus('scheduled')">
                            <i class="fas fa-calendar-check me-1"></i>
                            Schedule Activity
                        </button>
                    <?php elseif($activity->status === 'scheduled'): ?>
                        <button type="button" class="btn btn-primary btn-sm" onclick="updateStatus('completed')">
                            <i class="fas fa-check-circle me-1"></i>
                            Mark Completed
                        </button>
                        <button type="button" class="btn btn-warning btn-sm" onclick="updateStatus('cancelled')">
                            <i class="fas fa-times-circle me-1"></i>
                            Cancel Activity
                        </button>
                    <?php endif; ?>
                    
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
                    <strong><?php echo e($activity->name); ?></strong> will be permanently deleted. This action cannot be undone.
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
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
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
            url: `/api/activities/<?php echo e($activity->id); ?>`,
            method: 'DELETE',
            success: function(response) {
                if (response.success) {
                    window.location.href = '<?php echo e(route("activities.index")); ?>';
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
                location: '<?php echo e($activity->location); ?>',
                date: '<?php echo e($activity->preferred_date->format("Y-m-d")); ?>'
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
        url: `/api/activities/<?php echo e($activity->id); ?>`,
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
    const shareText = `Activity: <?php echo e($activity->name); ?>\nLocation: <?php echo e($activity->location); ?>\nDate: <?php echo e($activity->formatted_date); ?>`;
    
    if (navigator.share) {
        navigator.share({
            title: '<?php echo e($activity->name); ?>',
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
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\rama\persolkelly\hitachi_web_developer\outdoor-activity-scheduler\resources\views/activities/show.blade.php ENDPATH**/ ?>