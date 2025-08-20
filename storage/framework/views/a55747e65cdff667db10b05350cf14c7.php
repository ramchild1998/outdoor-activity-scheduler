

<?php $__env->startSection('title', 'Activities'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-12">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>
                <i class="fas fa-calendar-alt me-2"></i>
                Activities
            </h2>
            <div>
                <a href="<?php echo e(route('activities.create')); ?>" class="btn btn-primary btn-sm d-md-none" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-plus"></i>
                </a>
                <a href="<?php echo e(route('activities.create')); ?>" class="btn btn-primary d-none d-md-inline-flex align-items-center">
                    <i class="fas fa-plus me-1"></i>
                    New Activity
                </a>
            </div>
        </div>

        <!-- Filters -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="<?php echo e(route('activities.index')); ?>" class="row g-3" id="filterForm">
                    <div class="col-md-2">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" class="form-control" id="date" name="date" value="<?php echo e(request('date')); ?>">
                    </div>
                    <div class="col-md-2">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="">All Status</option>
                            <option value="pending" <?php echo e(request('status') == 'pending' ? 'selected' : ''); ?>>Pending</option>
                            <option value="scheduled" <?php echo e(request('status') == 'scheduled' ? 'selected' : ''); ?>>Scheduled</option>
                            <option value="completed" <?php echo e(request('status') == 'completed' ? 'selected' : ''); ?>>Completed</option>
                            <option value="cancelled" <?php echo e(request('status') == 'cancelled' ? 'selected' : ''); ?>>Cancelled</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="location" class="form-label">Location</label>
                        <input type="text" class="form-control" id="location" name="location"
                               value="<?php echo e(request('location')); ?>" placeholder="Search by location...">
                    </div>
                    <div class="col-md-2">
                        <label for="sort_by" class="form-label">Sort By</label>
                        <select class="form-select" id="sort_by" name="sort_by">
                            <option value="preferred_date" <?php echo e(request('sort_by', 'preferred_date') == 'preferred_date' ? 'selected' : ''); ?>>Date</option>
                            <option value="created_at" <?php echo e(request('sort_by') == 'created_at' ? 'selected' : ''); ?>>Created At</option>
                            <option value="name" <?php echo e(request('sort_by') == 'name' ? 'selected' : ''); ?>>Name</option>
                            <option value="status" <?php echo e(request('sort_by') == 'status' ? 'selected' : ''); ?>>Status</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="sort_order" class="form-label">Order</label>
                        <select class="form-select" id="sort_order" name="sort_order">
                            <option value="desc" <?php echo e(request('sort_order', 'desc') == 'desc' ? 'selected' : ''); ?>>Descending</option>
                            <option value="asc" <?php echo e(request('sort_order') == 'asc' ? 'selected' : ''); ?>>Ascending</option>
                        </select>
                    </div>
                    <div class="col-md-1">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-outline-primary btn-sm d-md-none" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-search"></i>
                            </button>
                            <button type="submit" class="btn btn-outline-primary d-none d-md-inline-flex align-items-center">
                                <i class="fas fa-search me-1"></i>
                                Filter
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Activities List -->
        <div class="activity-list">
        <?php if($activities->count() > 0): ?>
            <div class="row">
                <?php $__currentLoopData = $activities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-lg-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <h5 class="card-title mb-0"><?php echo e($activity->name); ?></h5>
                                <span class="activity-status status-<?php echo e($activity->status); ?>">
                                    <?php echo e(ucfirst($activity->status)); ?>

                                </span>
                            </div>
                            
                            <div class="mb-3">
                                <p class="card-text mb-2">
                                    <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                    <strong><?php echo e($activity->location); ?></strong>
                                    <?php if($activity->sub_district): ?>
                                        <br>
                                        <small class="text-muted ms-4"><?php echo e($activity->sub_district); ?></small>
                                        <?php if($activity->village): ?>
                                            <small class="text-muted">, <?php echo e($activity->village); ?></small>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </p>
                                
                                <p class="card-text mb-2">
                                    <i class="fas fa-calendar text-info me-2"></i>
                                    <?php echo e($activity->formatted_date); ?>

                                    <?php if($activity->selected_time_slot): ?>
                                        <i class="fas fa-clock text-warning ms-3 me-1"></i>
                                        <?php echo e($activity->formatted_time_slot); ?>

                                    <?php endif; ?>
                                </p>
                                
                                <?php if($activity->weather_condition): ?>
                                <p class="card-text mb-2">
                                    <i class="fas fa-cloud text-secondary me-2"></i>
                                    <?php echo e($activity->weather_condition); ?>

                                </p>
                                <?php endif; ?>
                                
                                <?php if($activity->notes): ?>
                                <p class="card-text">
                                    <i class="fas fa-sticky-note text-muted me-2"></i>
                                    <small class="text-muted"><?php echo e(Str::limit($activity->notes, 100)); ?></small>
                                </p>
                                <?php endif; ?>
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <i class="fas fa-clock me-1"></i>
                                    Created <?php echo e($activity->created_at->diffForHumans()); ?>

                                </small>
                                
                                <div class="btn-group" role="group">
                                    <a href="<?php echo e(route('activities.show', $activity)); ?>" 
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye me-1"></i>
                                        View
                                    </a>
                                    <?php if($activity->status === 'pending'): ?>
                                    <button type="button" 
                                            class="btn btn-sm btn-outline-success schedule-btn"
                                            data-activity-id="<?php echo e($activity->id); ?>"
                                            data-activity-name="<?php echo e($activity->name); ?>">
                                        <i class="fas fa-calendar-check me-1"></i>
                                        Schedule
                                    </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        
                        <?php if($activity->isPast() && $activity->status !== 'completed'): ?>
                        <div class="card-footer bg-warning bg-opacity-10">
                            <small class="text-warning">
                                <i class="fas fa-exclamation-triangle me-1"></i>
                                This activity date has passed
                            </small>
                        </div>
                        <?php elseif($activity->isToday()): ?>
                        <div class="card-footer bg-info bg-opacity-10">
                            <small class="text-info">
                                <i class="fas fa-calendar-day me-1"></i>
                                Scheduled for today
                            </small>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                <?php echo e($activities->appends(request()->query())->links()); ?>

            </div>
        <?php else: ?>
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="fas fa-calendar-times text-muted" style="font-size: 4rem;"></i>
                    <h4 class="mt-3 mb-3">No Activities Found</h4>
                    <p class="text-muted mb-4">
                        <?php if(request()->hasAny(['date', 'status', 'location'])): ?>
                            No activities match your current filters. Try adjusting your search criteria.
                        <?php else: ?>
                            You haven't created any activities yet. Start by scheduling your first outdoor activity!
                        <?php endif; ?>
                    </p>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                        <?php if(request()->hasAny(['date', 'status', 'location'])): ?>
                            <a href="<?php echo e(route('activities.index')); ?>" class="btn btn-outline-secondary me-md-2">
                                <i class="fas fa-times me-1"></i>
                                Clear Filters
                            </a>
                        <?php endif; ?>
                        <a href="<?php echo e(route('activities.create')); ?>" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i>
                            Create First Activity
                        </a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        </div>
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
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
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
    $('#date, #status, #location, #sort_by, #sort_order').on('input change', function() {
        const form = $(this).closest('form');
        const formData = form.serialize();
        
        // Show loading indicator
        $('.activity-list').html('<div class="text-center"><i class="fas fa-spinner fa-spin fa-3x"></i></div>');
        
        // Submit form via AJAX
        $.get(form.attr('action'), formData, function(data) {
            $('.activity-list').html($(data).find('.activity-list').html());
        }).fail(function() {
            $('.activity-list').html('<div class="alert alert-danger">Failed to load activities. Please try again.</div>');
        });
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\rama\persolkelly\hitachi_web_developer\outdoor-activity-scheduler\resources\views/activities/index.blade.php ENDPATH**/ ?>