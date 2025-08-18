

<?php $__env->startSection('title', 'Create New Activity'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">
                    <i class="fas fa-plus me-2"></i>
                    Create New Activity
                </h4>
            </div>
            <div class="card-body">
                <form id="activityForm" action="<?php echo e(route('activities.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">
                                    <i class="fas fa-tag me-1"></i>
                                    Activity Name *
                                </label>
                                <input type="text" 
                                       class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="name" 
                                       name="name" 
                                       value="<?php echo e(old('name')); ?>" 
                                       placeholder="e.g., Field Survey, Maintenance Check"
                                       required>
                                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="preferred_date" class="form-label">
                                    <i class="fas fa-calendar me-1"></i>
                                    Preferred Date *
                                </label>
                                <input type="date" 
                                       class="form-control <?php $__errorArgs = ['preferred_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="preferred_date" 
                                       name="preferred_date" 
                                       value="<?php echo e(old('preferred_date')); ?>" 
                                       min="<?php echo e(date('Y-m-d')); ?>"
                                       required>
                                <?php $__errorArgs = ['preferred_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="location" class="form-label">
                                    <i class="fas fa-map-marker-alt me-1"></i>
                                    Location/Province *
                                </label>
                                <select class="form-select <?php $__errorArgs = ['location'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                        id="location" 
                                        name="location" 
                                        required>
                                    <option value="">Select Province</option>
                                    <?php $__currentLoopData = $locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($name); ?>" <?php echo e(old('location') == $name ? 'selected' : ''); ?>>
                                            <?php echo e($name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['location'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="sub_district" class="form-label">
                                    <i class="fas fa-map me-1"></i>
                                    Sub-District
                                </label>
                                <input type="text" 
                                       class="form-control <?php $__errorArgs = ['sub_district'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="sub_district" 
                                       name="sub_district" 
                                       value="<?php echo e(old('sub_district')); ?>" 
                                       placeholder="e.g., Menteng, Kebayoran">
                                <?php $__errorArgs = ['sub_district'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="village" class="form-label">
                            <i class="fas fa-home me-1"></i>
                            Village/Area
                        </label>
                        <input type="text" 
                               class="form-control <?php $__errorArgs = ['village'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               id="village" 
                               name="village" 
                               value="<?php echo e(old('village')); ?>" 
                               placeholder="e.g., Menteng Dalam, Senayan">
                        <?php $__errorArgs = ['village'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">
                            <i class="fas fa-sticky-note me-1"></i>
                            Notes
                        </label>
                        <textarea class="form-control <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                  id="notes" 
                                  name="notes" 
                                  rows="3" 
                                  placeholder="Additional information about the activity..."><?php echo e(old('notes')); ?></textarea>
                        <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="<?php echo e(route('activities.index')); ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i>
                            Back to Activities
                        </a>
                        
                        <div>
                            <button type="button" class="btn btn-info me-2" id="checkWeatherBtn">
                                <i class="fas fa-cloud me-1"></i>
                                Check Weather First
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>
                                Create Activity
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Weather Suggestions Section -->
        <div id="weatherSuggestions" class="card mt-4" style="display: none;">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-cloud-sun me-2"></i>
                    Weather Suggestions
                </h5>
            </div>
            <div class="card-body">
                <div id="weatherContent">
                    <!-- Weather suggestions will be loaded here -->
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
$(document).ready(function() {
    // Check weather button functionality
    $('#checkWeatherBtn').click(function() {
        const location = $('#location').val();
        const date = $('#preferred_date').val();
        
        if (!location || !date) {
            alert('Please select both location and preferred date first.');
            return;
        }
        
        checkWeatherSuggestions(location, date);
    });
    
    // Auto-check weather when both location and date are selected
    $('#location, #preferred_date').change(function() {
        const location = $('#location').val();
        const date = $('#preferred_date').val();
        
        if (location && date) {
            setTimeout(() => {
                checkWeatherSuggestions(location, date);
            }, 500);
        }
    });
    
    function checkWeatherSuggestions(location, date) {
        $('#weatherSuggestions').show();
        $('#weatherContent').html(`
            <div class="text-center">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2">Loading weather suggestions...</p>
            </div>
        `);
        
        $.ajax({
            url: '/api/weather/suggestions',
            method: 'GET',
            data: {
                location: location,
                date: date
            },
            success: function(response) {
                if (response.success && response.data && response.data.suggestions && response.data.suggestions.length > 0) {
                    displayWeatherSuggestions(response.data.suggestions);
                } else {
                    $('#weatherContent').html(`
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            No weather data available for the selected location and date.
                        </div>
                    `);
                }
            },
            error: function(xhr, status, error) {
                $('#weatherContent').html(`
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        Failed to load weather data. Please try again.
                    </div>
                `);
            }
        });
    }
    
    function displayWeatherSuggestions(suggestions) {
        let html = '<div class="row">';
        
        suggestions.forEach(function(suggestion, index) {
            const cardClass = suggestion.is_optimal ? 'optimal' : 'not-optimal';
            const iconClass = suggestion.is_optimal ? 'fa-check-circle text-success' : 'fa-times-circle text-danger';
            
            html += `
                <div class="col-md-6 mb-3">
                    <div class="card weather-card ${cardClass} h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="card-title">
                                        <i class="fas fa-clock me-1"></i>
                                        ${suggestion.time}
                                    </h6>
                                    <p class="card-text mb-2">
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
                                    <i class="fas ${iconClass}" style="font-size: 1.5rem;"></i>
                                    <br>
                                    <small class="fw-bold ${suggestion.is_optimal ? 'text-success' : 'text-danger'}">
                                        ${suggestion.recommendation}
                                    </small>
                                </div>
                            </div>
                            ${suggestion.is_optimal ? `
                                <button type="button" class="btn btn-sm btn-success mt-2 select-time-btn" 
                                        data-datetime="${suggestion.datetime}">
                                    <i class="fas fa-check me-1"></i>
                                    Select This Time
                                </button>
                            ` : ''}
                        </div>
                    </div>
                </div>
            `;
        });
        
        html += '</div>';
        
        // Add summary
        const optimalCount = suggestions.filter(s => s.is_optimal).length;
        html = `
            <div class="alert alert-info mb-3">
                <i class="fas fa-info-circle me-2"></i>
                Found <strong>${optimalCount}</strong> optimal time slots out of <strong>${suggestions.length}</strong> available slots.
            </div>
        ` + html;
        
        $('#weatherContent').html(html);
        
        // Handle time selection
        $('.select-time-btn').click(function() {
            const datetime = $(this).data('datetime');
            $('#selected_time_slot').remove();
            $('#activityForm').append(`<input type="hidden" id="selected_time_slot" name="selected_time_slot" value="${datetime}">`);
            
            $('.select-time-btn').removeClass('btn-success').addClass('btn-outline-success').html('<i class="fas fa-check me-1"></i>Select This Time');
            $(this).removeClass('btn-outline-success').addClass('btn-success').html('<i class="fas fa-check-circle me-1"></i>Selected');
            
            // Show confirmation
            const timeStr = new Date(datetime).toLocaleTimeString('en-US', {hour: '2-digit', minute:'2-digit'});
            $('#weatherSuggestions').after(`
                <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    Selected time slot: <strong>${timeStr}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `);
        });
    }
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\rama\persolkelly\hitachi_web_developer\outdoor-activity-scheduler\resources\views/activities/create.blade.php ENDPATH**/ ?>