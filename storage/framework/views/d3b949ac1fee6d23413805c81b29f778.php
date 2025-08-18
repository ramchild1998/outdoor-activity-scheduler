

<?php $__env->startSection('title', 'Welcome'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-lg-8 mx-auto">
        <!-- Hero Section -->
        <div class="card mb-4">
            <div class="card-body text-center py-5">
                <i class="fas fa-cloud-sun text-primary" style="font-size: 4rem;"></i>
                <h1 class="display-4 mt-3 mb-3">Outdoor Activity Scheduler</h1>
                <p class="lead text-muted mb-4">
                    Plan your outdoor activities with intelligent weather-based recommendations using BMKG weather data.
                </p>
                <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                    <a href="<?php echo e(route('activities.create')); ?>" class="btn btn-primary btn-lg me-md-2">
                        <i class="fas fa-plus me-2"></i>
                        Schedule New Activity
                    </a>
                    <a href="<?php echo e(route('activities.index')); ?>" class="btn btn-outline-primary btn-lg">
                        <i class="fas fa-list me-2"></i>
                        View Activities
                    </a>
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <i class="fas fa-cloud-rain text-info mb-3" style="font-size: 2.5rem;"></i>
                        <h5 class="card-title">Weather Integration</h5>
                        <p class="card-text">
                            Real-time weather data from BMKG API to help you choose the best time for outdoor activities.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <i class="fas fa-calendar-check text-success mb-3" style="font-size: 2.5rem;"></i>
                        <h5 class="card-title">Smart Scheduling</h5>
                        <p class="card-text">
                            Get optimal time slot suggestions based on weather conditions for your planned activities.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <i class="fas fa-map-marker-alt text-warning mb-3" style="font-size: 2.5rem;"></i>
                        <h5 class="card-title">Location-Based</h5>
                        <p class="card-text">
                            Support for all Indonesian provinces with detailed sub-district and village information.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-chart-bar me-2"></i>
                    Quick Overview
                </h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-3">
                        <div class="border-end">
                            <h3 class="text-primary mb-1"><?php echo e(\App\Models\Activity::count()); ?></h3>
                            <small class="text-muted">Total Activities</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="border-end">
                            <h3 class="text-success mb-1"><?php echo e(\App\Models\Activity::where('status', 'scheduled')->count()); ?></h3>
                            <small class="text-muted">Scheduled</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="border-end">
                            <h3 class="text-info mb-1"><?php echo e(\App\Models\Activity::where('status', 'completed')->count()); ?></h3>
                            <small class="text-muted">Completed</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <h3 class="text-warning mb-1"><?php echo e(\App\Models\Activity::where('status', 'pending')->count()); ?></h3>
                        <small class="text-muted">Pending</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activities -->
        <?php
            $recentActivities = \App\Models\Activity::latest()->take(3)->get();
        ?>
        
        <?php if($recentActivities->count() > 0): ?>
        <div class="card mt-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-clock me-2"></i>
                    Recent Activities
                </h5>
                <a href="<?php echo e(route('activities.index')); ?>" class="btn btn-sm btn-outline-primary">
                    View All
                </a>
            </div>
            <div class="card-body">
                <?php $__currentLoopData = $recentActivities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="d-flex justify-content-between align-items-center py-2 <?php echo e(!$loop->last ? 'border-bottom' : ''); ?>">
                    <div>
                        <h6 class="mb-1"><?php echo e($activity->name); ?></h6>
                        <small class="text-muted">
                            <i class="fas fa-map-marker-alt me-1"></i>
                            <?php echo e($activity->location); ?>

                            <?php if($activity->preferred_date): ?>
                                <i class="fas fa-calendar ms-2 me-1"></i>
                                <?php echo e($activity->formatted_date); ?>

                            <?php endif; ?>
                        </small>
                    </div>
                    <span class="activity-status status-<?php echo e($activity->status); ?>">
                        <?php echo e(ucfirst($activity->status)); ?>

                    </span>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- Weather Info -->
        <div class="card mt-4">
            <div class="card-body text-center">
                <h6 class="card-title">
                    <i class="fas fa-info-circle me-2"></i>
                    Weather Data Information
                </h6>
                <p class="card-text small text-muted mb-0">
                    Weather forecasts are provided by BMKG (Badan Meteorologi, Klimatologi, dan Geofisika) 
                    and updated regularly to ensure accurate activity planning recommendations.
                </p>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
$(document).ready(function() {
    // Add some animation to the hero section
    $('.card').first().hide().fadeIn(1000);
    
    // Animate feature cards
    $('.row .col-md-4').each(function(index) {
        $(this).delay(200 * index).fadeIn(500);
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\rama\persolkelly\hitachi_web_developer\outdoor-activity-scheduler\resources\views/welcome.blade.php ENDPATH**/ ?>