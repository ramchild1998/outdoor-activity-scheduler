<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'Laravel')); ?> - <?php echo $__env->yieldContent('title', 'Outdoor Activity Scheduler'); ?></title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />

    <!-- Custom CSS -->
    <style>
        /* CSS Variables for consistent theming */
        :root {
            --primary-color: #007bff;
            --primary-hover: #0056b3;
            --success-color: #28a745;
            --danger-color: #dc3545;
            --warning-color: #ffc107;
            --info-color: #17a2b8;
            --light-color: #f8f9fa;
            --dark-color: #343a40;
            --border-radius: 0.5rem;
            --box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            --box-shadow-lg: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            --transition: all 0.3s ease;
        }

        /* Base Typography - Responsive */
        body {
            font-family: 'Figtree', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
        }

        h1, .display-4 { font-size: clamp(1.75rem, 4vw, 2.5rem); }
        h2 { font-size: clamp(1.5rem, 3vw, 2rem); }
        h3 { font-size: clamp(1.25rem, 2.5vw, 1.75rem); }
        h4 { font-size: clamp(1.125rem, 2vw, 1.5rem); }
        h5 { font-size: clamp(1rem, 1.5vw, 1.25rem); }

        /* Container Improvements */
        .container {
            padding-left: 1rem;
            padding-right: 1rem;
        }

        /* Enhanced Professional Navbar */
        .navbar {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-hover)) !important;
            box-shadow: 0 0.25rem 0.75rem rgba(0, 123, 255, 0.15);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 0.75rem 0;
            position: relative;
            z-index: 1040;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: clamp(1.1rem, 2vw, 1.25rem);
            display: flex;
            align-items: center;
            text-decoration: none;
            color: white !important;
            transition: var(--transition);
        }

        .navbar-brand:hover {
            color: rgba(255, 255, 255, 0.9) !important;
            transform: translateY(-1px);
        }

        .brand-icon {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            margin-right: 0.75rem;
            transition: var(--transition);
        }

        .navbar-brand:hover .brand-icon {
            background: rgba(255, 255, 255, 0.25);
            transform: rotate(10deg);
        }

        .brand-text {
            display: flex;
            flex-direction: column;
        }

        .brand-title {
            font-size: 1.1rem;
            font-weight: 700;
            line-height: 1.2;
        }

        .brand-subtitle {
            font-size: 0.75rem;
            opacity: 0.8;
            font-weight: 400;
            line-height: 1;
        }

        .navbar-nav .nav-link {
            font-weight: 500;
            padding: 0.625rem 1rem;
            border-radius: var(--border-radius);
            transition: var(--transition);
            color: rgba(255, 255, 255, 0.9) !important;
            position: relative;
            margin: 0 0.25rem;
        }

        .navbar-nav .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.15);
            color: white !important;
            transform: translateY(-1px);
        }

        .navbar-nav .nav-link.active {
            background-color: rgba(255, 255, 255, 0.2);
            color: white !important;
            font-weight: 600;
        }

        .navbar-nav .nav-link i {
            margin-right: 0.5rem;
            width: 16px;
            text-align: center;
        }

        .dropdown-menu {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.2);
            background: white;
            margin-top: 0.5rem;
            padding: 0.375rem;
            min-width: 220px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(0, 0, 0, 0.05);
            z-index: 1050;
            position: absolute;
        }

        .dropdown-item {
            padding: 0.5rem 0.875rem;
            transition: var(--transition);
            border-radius: calc(var(--border-radius) - 0.125rem);
            margin: 0.0625rem 0;
            font-weight: 500;
            color: #495057;
            display: flex;
            align-items: center;
            text-decoration: none;
            font-size: 0.9rem;
            line-height: 1.4;
        }

        .dropdown-item:hover {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
            color: white;
            transform: translateX(3px);
            box-shadow: 0 0.1875rem 0.375rem rgba(0, 123, 255, 0.25);
        }

        .dropdown-item:focus {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
            color: white;
            outline: none;
        }

        .dropdown-item i {
            width: 16px;
            text-align: center;
            margin-right: 0.625rem;
            font-size: 0.875rem;
            flex-shrink: 0;
        }

        .dropdown-divider {
            margin: 0.375rem 0;
            border-color: rgba(0, 0, 0, 0.08);
            opacity: 0.5;
        }

        /* Enhanced dropdown toggle styling */
        .nav-link.dropdown-toggle {
            position: relative;
        }

        .nav-link.dropdown-toggle::after {
            margin-left: 0.5rem;
            transition: var(--transition);
        }

        .nav-link.dropdown-toggle[aria-expanded="true"]::after {
            transform: rotate(180deg);
        }

        .nav-link.dropdown-toggle:hover::after {
            color: rgba(255, 255, 255, 0.8);
        }

        .navbar-toggler {
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: var(--border-radius);
            padding: 0.375rem 0.5rem;
            transition: var(--transition);
        }

        .navbar-toggler:hover {
            border-color: rgba(255, 255, 255, 0.5);
            background-color: rgba(255, 255, 255, 0.1);
        }

        .navbar-toggler:focus {
            box-shadow: 0 0 0 0.2rem rgba(255, 255, 255, 0.25);
        }

        /* Enhanced Cards */
        .card {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            transition: var(--transition);
            overflow: hidden;
        }

        .card:hover {
            box-shadow: var(--box-shadow-lg);
            transform: translateY(-2px);
        }

        .card-header {
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            background: linear-gradient(135deg, var(--primary-color), #0056b3);
            color: white;
        }

        /* Weather Card Enhancements */
        .weather-card {
            border-left: 4px solid var(--primary-color);
            transition: var(--transition);
            border-radius: var(--border-radius);
            overflow: hidden;
        }

        .weather-card.optimal {
            border-left-color: var(--success-color);
            background: linear-gradient(135deg, #f8fff9, #e8f5e8);
        }

        .weather-card.not-optimal {
            border-left-color: var(--danger-color);
            background: linear-gradient(135deg, #fff8f8, #ffeaea);
        }

        .weather-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--box-shadow-lg);
        }

        /* Activity Status Badges */
        .activity-status {
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.375rem 0.75rem;
            border-radius: 50px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: var(--box-shadow);
        }

        .status-pending {
            background: linear-gradient(135deg, #fff3cd, #ffeaa7);
            color: #856404;
        }
        .status-scheduled {
            background: linear-gradient(135deg, #d4edda, #a8e6cf);
            color: #155724;
        }
        .status-completed {
            background: linear-gradient(135deg, #cce7ff, #74b9ff);
            color: #004085;
        }
        .status-cancelled {
            background: linear-gradient(135deg, #f8d7da, #ff7675);
            color: #721c24;
        }

        /* Enhanced Buttons */
        .btn {
            font-weight: 500;
            border-radius: var(--border-radius);
            transition: var(--transition);
            box-shadow: var(--box-shadow);
            border: none;
            padding: 0.625rem 1.25rem;
            font-size: 0.95rem;
            line-height: 1.5;
            min-height: 44px; /* Touch-friendly minimum height */
        }

        .btn-sm {
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
            min-height: 36px;
        }

        .btn-lg {
            padding: 0.75rem 1.5rem;
            font-size: 1.125rem;
            min-height: 52px;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-hover), #003d82);
            transform: translateY(-1px);
            box-shadow: var(--box-shadow-lg);
        }

        .btn-success {
            background: linear-gradient(135deg, var(--success-color), #1e7e34);
        }

        .btn-info {
            background: linear-gradient(135deg, var(--info-color), #138496);
        }

        .btn-warning {
            background: linear-gradient(135deg, var(--warning-color), #e0a800);
        }

        .btn-danger {
            background: linear-gradient(135deg, var(--danger-color), #c82333);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #6c757d, #5a6268);
        }

        /* Button Groups */
        .btn-group .btn {
            min-height: auto;
        }

        /* Icon buttons */
        .btn .fas, .btn .far, .btn .fab {
            margin-right: 0.375rem;
        }

        .btn .fas:last-child, .btn .far:last-child, .btn .fab:last-child {
            margin-right: 0;
            margin-left: 0.375rem;
        }

        /* Modal Enhancements */
        .modal-content {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175);
            overflow: hidden;
        }

        .modal-header {
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding: 1.5rem;
        }

        .modal-body {
            padding: 1.5rem;
        }

        .modal-footer {
            border-top: 1px solid rgba(0, 0, 0, 0.05);
            padding: 1.5rem;
        }

        /* Form Enhancements */
        .form-control, .form-select {
            border: 2px solid #e9ecef;
            border-radius: var(--border-radius);
            transition: var(--transition);
            font-size: 0.95rem;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .form-label {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
        }

        /* Table Enhancements */
        .table {
            border-radius: var(--border-radius);
            overflow: hidden;
        }

        .table thead th {
            border: none;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.875rem;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.02);
        }

        .table-hover tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.05);
        }

        /* Alert Enhancements */
        .alert {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
        }

        .alert-info {
            background: linear-gradient(135deg, #d1ecf1, #bee5eb);
            color: #0c5460;
        }

        .alert-success {
            background: linear-gradient(135deg, #d4edda, #c3e6cb);
            color: #155724;
        }

        .alert-warning {
            background: linear-gradient(135deg, #fff3cd, #ffeaa7);
            color: #856404;
        }

        .alert-danger {
            background: linear-gradient(135deg, #f8d7da, #f5c6cb);
            color: #721c24;
        }

        /* Badge Enhancements */
        .badge {
            font-weight: 500;
            border-radius: 50px;
            padding: 0.375rem 0.75rem;
        }

        /* Tablet Optimizations */
        @media (max-width: 992px) {
            .btn {
                padding: 0.625rem 1.125rem;
                font-size: 0.95rem;
                min-height: 46px;
            }

            .btn-lg {
                padding: 0.75rem 1.375rem;
                font-size: 1.1rem;
                min-height: 50px;
            }

            .btn-sm {
                padding: 0.375rem 0.75rem;
                font-size: 0.875rem;
                min-height: 38px;
            }
        }

        /* Mobile Optimizations */
        @media (max-width: 768px) {
            .container {
                padding-left: 0.75rem;
                padding-right: 0.75rem;
            }

            .card-body {
                padding: 1rem;
            }

            .modal-dialog {
                margin: 0.5rem;
            }

            .modal-header, .modal-body, .modal-footer {
                padding: 1rem;
            }

            /* Enhanced Mobile Button Sizing */
            .btn {
                padding: 0.75rem 1.25rem;
                font-size: 1rem;
                min-height: 48px;
                width: auto;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                text-align: center;
            }

            .btn-lg {
                padding: 0.875rem 1.5rem;
                font-size: 1.125rem;
                min-height: 52px;
            }

            .btn-sm {
                padding: 0.5rem 1rem;
                font-size: 0.9rem;
                min-height: 42px;
            }

            .btn-group .btn {
                padding: 0.5rem 0.875rem;
                font-size: 0.875rem;
                min-height: 40px;
            }

            /* Full-width buttons in specific contexts */
            .modal-footer .btn {
                flex: 1;
                margin: 0 0.25rem;
            }

            .navbar-brand {
                font-size: 1.1rem;
            }

            .display-4 {
                font-size: 1.75rem;
                margin-bottom: 1rem;
            }

            .lead {
                font-size: 1rem;
            }

            /* Stack buttons vertically on mobile */
            .d-grid.gap-2.d-md-flex.justify-content-md-center {
                gap: 0.75rem !important;
            }

            .d-grid.gap-2.d-md-flex.justify-content-md-center .btn {
                width: 100%;
                margin-bottom: 0.5rem;
                min-height: 50px;
            }

            /* Hero section buttons */
            .card-body .btn {
                min-width: 200px;
                margin: 0.25rem;
            }

            /* Improve table responsiveness */
            .table-responsive {
                border-radius: var(--border-radius);
            }

            /* Better spacing for mobile */
            .mb-4 {
                margin-bottom: 1.5rem !important;
            }

            .py-4 {
                padding-top: 1.5rem !important;
                padding-bottom: 1.5rem !important;
            }

            .py-5 {
                padding-top: 2rem !important;
                padding-bottom: 2rem !important;
            }

            /* Mobile-friendly navbar */
            .navbar-toggler {
                border: none;
                padding: 0.375rem 0.5rem;
                min-height: 44px;
            }

            .navbar-toggler:focus {
                box-shadow: none;
            }

            .navbar-collapse {
                margin-top: 0.5rem;
            }

            .navbar-nav .nav-link {
                padding: 0.75rem 1rem;
                margin: 0.125rem 0;
                border-radius: var(--border-radius);
                min-height: 44px;
                display: flex;
                align-items: center;
            }

            .dropdown-menu {
                border: none;
                box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.25);
                border-radius: var(--border-radius);
                min-width: 280px;
                padding: 0.75rem;
                margin-top: 0.75rem;
                z-index: 1055;
                position: absolute;
                background: white;
            }

            .dropdown-item {
                padding: 1rem 1.25rem;
                min-height: 48px;
                display: flex;
                align-items: center;
                border-radius: var(--border-radius);
                margin: 0.25rem 0;
                font-size: 1rem;
                font-weight: 500;
            }

            .dropdown-item i {
                width: 24px;
                margin-right: 1rem;
                font-size: 1.1rem;
            }

            .dropdown-item:hover {
                background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
                color: white;
                transform: translateX(8px);
                box-shadow: 0 0.375rem 0.75rem rgba(0, 123, 255, 0.4);
            }
        }

        /* Small mobile devices */
        @media (max-width: 576px) {
            .modal-dialog {
                margin: 0.25rem;
            }

            .card {
                margin-bottom: 1rem;
            }

            .row.g-4 {
                --bs-gutter-y: 1rem;
            }

            /* Single column layout for feature cards */
            .col-md-4 {
                margin-bottom: 1rem;
            }

            /* Adjust hero section */
            .card-body.text-center.py-5 {
                padding: 1.5rem !important;
            }

            /* Enhanced Small Mobile Dropdown Styling */
            .dropdown-menu {
                min-width: 320px;
                padding: 1rem;
                margin-top: 1rem;
                box-shadow: 0 1rem 2.5rem rgba(0, 0, 0, 0.35);
                border-radius: 1rem;
                z-index: 1060;
                position: absolute;
                background: white;
                border: none;
            }

            .dropdown-item {
                min-height: 52px;
                padding: 1rem 1.25rem;
                border-radius: 0.75rem;
                margin: 0.375rem 0;
                font-size: 1.05rem;
                font-weight: 500;
                display: flex;
                align-items: center;
            }

            .dropdown-item i {
                width: 28px;
                margin-right: 1rem;
                font-size: 1.2rem;
                flex-shrink: 0;
            }

            .dropdown-item:hover {
                background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
                color: white;
                transform: translateX(12px);
                box-shadow: 0 0.5rem 1rem rgba(0, 123, 255, 0.5);
            }

            .dropdown-divider {
                margin: 0.75rem 0;
                opacity: 0.4;
            }

            /* Enhanced Small Mobile Button Sizing */
            .btn {
                padding: 0.875rem 1.5rem;
                font-size: 1.05rem;
                min-height: 50px;
                width: 100%;
                margin-bottom: 0.5rem;
                border-radius: 0.75rem;
            }

            .btn-lg {
                padding: 1rem 1.75rem;
                font-size: 1.125rem;
                min-height: 54px;
                border-radius: 0.875rem;
            }

            .btn-sm {
                padding: 0.625rem 1.125rem;
                font-size: 0.95rem;
                min-height: 44px;
                border-radius: 0.625rem;
            }

            /* Inline buttons should not be full width */
            .btn-group .btn,
            .d-inline .btn,
            .d-inline-block .btn {
                width: auto;
                margin-bottom: 0;
                margin-right: 0.5rem;
            }

            /* Modal buttons */
            .modal-footer .btn {
                width: 100%;
                margin: 0.25rem 0;
                flex: none;
            }

            .modal-footer .btn:last-child {
                margin-bottom: 0;
            }

            /* Navigation buttons */
            .navbar-nav .nav-link {
                min-height: 48px;
                padding: 0.875rem 1rem;
                margin: 0.25rem 0;
                border-radius: 0.75rem;
            }

            .dropdown-item {
                min-height: 48px;
                padding: 0.875rem 1rem;
                border-radius: 0.5rem;
                margin: 0.125rem 0.5rem;
            }

            /* Hero section specific buttons */
            .card-body .d-grid .btn,
            .card-body .d-md-flex .btn {
                min-width: 100%;
                margin: 0.375rem 0;
            }

            /* Form buttons */
            .form-actions .btn,
            .btn-toolbar .btn {
                width: 100%;
                margin: 0.25rem 0;
            }

            /* Improve form layout */
            .row .col-md-6 {
                margin-bottom: 1rem;
            }

            /* Footer adjustments */
            .footer .col-md-6 {
                text-align: center !important;
                margin-bottom: 1rem;
            }

            .footer .col-md-6:last-child {
                margin-bottom: 0;
            }

            /* Table action buttons */
            .table .btn {
                width: auto;
                min-width: 80px;
                margin: 0.125rem;
                padding: 0.375rem 0.75rem;
                font-size: 0.875rem;
                min-height: 36px;
            }

            /* Form page specific button improvements */
            .card-body form .d-flex.justify-content-between {
                flex-direction: column;
                gap: 1rem;
                align-items: stretch;
            }

            .card-body form .d-flex.justify-content-between > div {
                display: flex;
                flex-direction: column;
                gap: 0.5rem;
            }

            .card-body form .d-flex.justify-content-between .btn {
                width: 100%;
                margin: 0.25rem 0;
                padding: 0.625rem 1rem;
                font-size: 0.9rem;
                min-height: 42px;
                min-width: auto;
            }

            /* Weather suggestion buttons */
            .select-time-btn {
                padding: 0.375rem 0.75rem !important;
                font-size: 0.8rem !important;
                min-height: 36px !important;
                width: 100% !important;
                margin-top: 0.5rem !important;
            }
        }

        /* Extra small mobile devices */
        @media (max-width: 480px) {
            .card-body form .btn {
                padding: 0.5rem 0.875rem;
                font-size: 0.85rem;
                min-height: 40px;
            }

            .btn-sm {
                padding: 0.375rem 0.625rem;
                font-size: 0.8rem;
                min-height: 36px;
            }
        }

        /* Large screens */
        @media (min-width: 1200px) {
            .container {
                max-width: 1140px;
            }

            .card-body {
                padding: 2rem;
            }

            .modal-lg {
                max-width: 900px;
            }
        }

        /* Animation improvements */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card {
            animation: fadeInUp 0.6s ease-out;
        }

        /* Loading states */
        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
        }

        /* Accessibility improvements */
        .btn:focus, .form-control:focus, .form-select:focus {
            outline: 2px solid var(--primary-color);
            outline-offset: 2px;
        }

        /* Print styles */
        @media print {
            .navbar, .btn, .modal {
                display: none !important;
            }
            
            .card {
                box-shadow: none;
                border: 1px solid #dee2e6;
            }
        }

        /* Enhanced Professional Footer */
        .footer {
            background: linear-gradient(135deg, #2c3e50, #34495e) !important;
            color: #ecf0f1;
            position: relative;
            overflow: hidden;
        }

        .footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        }

        .footer h5 {
            color: #3498db;
            font-weight: 700;
            margin-bottom: 1rem;
            position: relative;
        }

        .footer h5::after {
            content: '';
            position: absolute;
            bottom: -0.5rem;
            left: 0;
            width: 50px;
            height: 2px;
            background: linear-gradient(90deg, #3498db, #2980b9);
            border-radius: 1px;
        }

        .footer p {
            color: #bdc3c7;
            line-height: 1.6;
            margin-bottom: 0.75rem;
        }

        .footer .text-muted {
            color: #95a5a6 !important;
        }

        .footer-feature {
            display: flex;
            align-items: center;
            padding: 0.5rem 0;
            transition: var(--transition);
            border-radius: 0.25rem;
        }

        .footer-feature:hover {
            background-color: rgba(255, 255, 255, 0.05);
            transform: translateX(5px);
        }

        .footer-feature i {
            width: 20px;
            color: #3498db;
            margin-right: 0.5rem;
        }

        .footer-info {
            display: flex;
            align-items: center;
            margin-bottom: 0.5rem;
            padding: 0.25rem 0;
        }

        .footer-info i {
            width: 20px;
            color: #e74c3c;
            margin-right: 0.5rem;
        }

        .footer-tech {
            display: inline-flex;
            align-items: center;
            background: rgba(52, 152, 219, 0.1);
            padding: 0.25rem 0.75rem;
            border-radius: 1rem;
            margin: 0.25rem 0.25rem 0.25rem 0;
            transition: var(--transition);
            border: 1px solid rgba(52, 152, 219, 0.2);
        }

        .footer-tech:hover {
            background: rgba(52, 152, 219, 0.2);
            transform: translateY(-1px);
        }

        .footer-tech i {
            margin-right: 0.375rem;
            color: #3498db;
        }

        .footer-copyright {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            text-align: center;
            color: #95a5a6;
        }

        .footer-social {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-bottom: 1rem;
        }

        .footer-social a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            color: #bdc3c7;
            transition: var(--transition);
            text-decoration: none;
        }

        .footer-social a:hover {
            background: #3498db;
            color: white;
            transform: translateY(-2px);
        }

        /* Mobile footer adjustments */
        @media (max-width: 768px) {
            .footer h5::after {
                left: 50%;
                transform: translateX(-50%);
            }

            .footer-feature {
                justify-content: center;
            }

            .footer-info {
                justify-content: center;
            }

            .footer-tech {
                margin: 0.25rem auto;
                display: flex;
            }
        }
    </style>

    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="bg-light">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="<?php echo e(url('/')); ?>">
                <div class="brand-icon">
                    <i class="fas fa-cloud-sun"></i>
                </div>
                <div class="brand-text">
                    <div class="brand-title"><?php echo e(config('app.name', 'Outdoor Activity Scheduler')); ?></div>
                    <div class="brand-subtitle">Weather-Based Activity Planning</div>
                </div>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('activities.*') ? 'active' : ''); ?>" href="<?php echo e(route('activities.index')); ?>">
                            <i class="fas fa-calendar-alt"></i>
                            <span>Activities</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('activities.create') ? 'active' : ''); ?>" href="<?php echo e(route('activities.create')); ?>">
                            <i class="fas fa-plus"></i>
                            <span>New Activity</span>
                        </a>
                    </li>
                </ul>
                
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-cloud"></i>
                            <span>Weather Tools</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="#" onclick="checkWeather()">
                                    <i class="fas fa-search"></i>
                                    Check Weather Forecast
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="#" onclick="viewLocations()">
                                    <i class="fas fa-map-marker-alt"></i>
                                    Available Locations
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="py-4">
        <div class="container">
            <!-- Flash Messages -->
            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    <?php echo e(session('success')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <?php echo e(session('error')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if($errors->any()): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Please fix the following errors:</strong>
                    <ul class="mb-0 mt-2">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer py-5 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                    <h5>
                        <i class="fas fa-cloud-sun me-2"></i>
                        Outdoor Activity Scheduler
                    </h5>
                    <p>Plan your outdoor activities with intelligent weather-based recommendations using real-time BMKG weather data.</p>
                    
                    <div class="footer-features">
                        <div class="footer-feature">
                            <i class="fas fa-calendar-alt"></i>
                            <span>Smart Activity Planning</span>
                        </div>
                        <div class="footer-feature">
                            <i class="fas fa-cloud"></i>
                            <span>Real-time Weather Integration</span>
                        </div>
                        <div class="footer-feature">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Location-based Recommendations</span>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                    <h5>System Information</h5>
                    <div class="footer-info">
                        <i class="fas fa-database"></i>
                        <span>Weather data provided by <strong>BMKG</strong></span>
                    </div>
                    <div class="footer-info">
                        <i class="fas fa-shield-alt"></i>
                        <span>Secure & Reliable Platform</span>
                    </div>
                    <div class="footer-info">
                        <i class="fas fa-clock"></i>
                        <span>Real-time Data Processing</span>
                    </div>
                    <div class="footer-info">
                        <i class="fas fa-mobile-alt"></i>
                        <span>Mobile-Responsive Design</span>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-12">
                    <h5>Technology Stack</h5>
                    <p class="mb-3">Built with modern web technologies for optimal performance and user experience.</p>
                    
                    <div class="d-flex flex-wrap">
                        <div class="footer-tech">
                            <i class="fab fa-laravel"></i>
                            <span>Laravel 11</span>
                        </div>
                        <div class="footer-tech">
                            <i class="fab fa-bootstrap"></i>
                            <span>Bootstrap 5</span>
                        </div>
                        <div class="footer-tech">
                            <i class="fab fa-php"></i>
                            <span>PHP 8.2</span>
                        </div>
                        <div class="footer-tech">
                            <i class="fas fa-database"></i>
                            <span>MySQL</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="footer-copyright">
                <div class="footer-social">
                    <a href="#" title="Documentation">
                        <i class="fas fa-book"></i>
                    </a>
                    <a href="#" title="Support">
                        <i class="fas fa-life-ring"></i>
                    </a>
                    <a href="#" title="Settings">
                        <i class="fas fa-cog"></i>
                    </a>
                </div>
                <p class="mb-0">
                    © <?php echo e(date('Y')); ?> <strong>Hitachi Internal System Developer</strong> - Outdoor Activity Scheduler
                    <br>
                    <small class="text-muted">Professional Weather-Based Activity Planning Solution</small>
                </p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Custom JavaScript -->
    <script>
        // CSRF Token setup for AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Check weather function
        function checkWeather() {
            showWeatherCheckModal();
        }

        // Show weather check modal
        function showWeatherCheckModal() {
            const modalHtml = `
                <div class="modal fade" id="weatherCheckModal" tabindex="-1" aria-labelledby="weatherCheckModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-info text-white">
                                <h5 class="modal-title" id="weatherCheckModalLabel">
                                    <i class="fas fa-cloud-sun me-2"></i>
                                    Check Weather Forecast
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="weatherCheckForm">
                                    <div class="mb-3">
                                        <label for="weatherLocation" class="form-label">
                                            <i class="fas fa-map-marker-alt me-1"></i>
                                            Location/Province *
                                        </label>
                                        <select class="form-select" id="weatherLocation" required>
                                            <option value="">Select Province</option>
                                        </select>
                                        <div class="form-text">Choose a province to get weather forecast</div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="weatherDate" class="form-label">
                                            <i class="fas fa-calendar me-1"></i>
                                            Date *
                                        </label>
                                        <input type="date" class="form-control" id="weatherDate" required min="${new Date().toISOString().split('T')[0]}">
                                        <div class="form-text">Select date for weather forecast (today or future dates)</div>
                                    </div>
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle me-2"></i>
                                        <strong>Weather Information:</strong> Get 3-day weather forecast with optimal time slot recommendations for outdoor activities.
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    <i class="fas fa-times me-1"></i>
                                    Cancel
                                </button>
                                <button type="button" class="btn btn-info" id="getWeatherBtn">
                                    <i class="fas fa-search me-1"></i>
                                    Get Weather Forecast
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            // Remove existing modal if any
            const existingModal = document.getElementById('weatherCheckModal');
            if (existingModal) {
                existingModal.remove();
            }

            // Add modal to body
            document.body.insertAdjacentHTML('beforeend', modalHtml);

            // Load provinces into select
            loadProvincesForWeather();

            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('weatherCheckModal'));
            modal.show();

            // Handle form submission
            document.getElementById('getWeatherBtn').addEventListener('click', function() {
                const location = document.getElementById('weatherLocation').value;
                const date = document.getElementById('weatherDate').value;
                
                if (!location || !date) {
                    alert('Please select both location and date');
                    return;
                }
                
                // Show loading state
                this.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Loading...';
                this.disabled = true;
                
                // Get weather suggestions
                getWeatherSuggestions(location, date);
            });

            // Clean up when modal is hidden
            document.getElementById('weatherCheckModal').addEventListener('hidden.bs.modal', function () {
                this.remove();
            });
        }

        // Load provinces for weather check
        function loadProvincesForWeather() {
            fetch('/api/weather/locations')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const select = document.getElementById('weatherLocation');
                        Object.entries(data.data.locations).forEach(([id, name]) => {
                            const option = document.createElement('option');
                            option.value = name;
                            option.textContent = name;
                            select.appendChild(option);
                        });
                    }
                })
                .catch(error => {
                    console.error('Error loading provinces:', error);
                });
        }

        // Get weather suggestions and show results
        function getWeatherSuggestions(location, date) {
            fetch(`/api/weather/suggestions?location=${encodeURIComponent(location)}&date=${date}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showWeatherResults(data.data, location, date);
                    } else {
                        alert('Failed to get weather data. Please try again.');
                        resetWeatherButton();
                    }
                })
                .catch(error => {
                    console.error('Error getting weather:', error);
                    alert('Failed to get weather data. Please try again.');
                    resetWeatherButton();
                });
        }

        // Show weather results in modal
        function showWeatherResults(weatherData, location, date) {
            const suggestions = weatherData.suggestions || [];
            const optimalCount = weatherData.optimal_count || 0;
            const totalSlots = weatherData.total_slots || suggestions.length;

            let resultsHtml = `
                <div class="mb-3">
                    <h6><i class="fas fa-map-marker-alt me-1"></i> ${location}</h6>
                    <p class="text-muted mb-0"><i class="fas fa-calendar me-1"></i> ${new Date(date).toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })}</p>
                </div>
                
                <div class="alert alert-info mb-3">
                    <i class="fas fa-info-circle me-2"></i>
                    Found <strong>${optimalCount}</strong> optimal time slots out of <strong>${totalSlots}</strong> available slots.
                </div>
            `;

            if (suggestions.length > 0) {
                resultsHtml += '<div class="row">';
                suggestions.forEach(suggestion => {
                    const cardClass = suggestion.is_optimal ? 'border-success' : 'border-danger';
                    const iconClass = suggestion.is_optimal ? 'fa-check-circle text-success' : 'fa-times-circle text-danger';
                    const bgClass = suggestion.is_optimal ? 'bg-success bg-opacity-10' : 'bg-danger bg-opacity-10';
                    
                    resultsHtml += `
                        <div class="col-md-6 mb-3">
                            <div class="card ${cardClass} ${bgClass} h-100">
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
                                </div>
                            </div>
                        </div>
                    `;
                });
                resultsHtml += '</div>';
            } else {
                resultsHtml += `
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        No weather data available for the selected location and date.
                    </div>
                `;
            }

            // Update modal content
            const modalBody = document.querySelector('#weatherCheckModal .modal-body');
            modalBody.innerHTML = resultsHtml;

            // Update modal title
            document.getElementById('weatherCheckModalLabel').innerHTML = `
                <i class="fas fa-cloud-sun me-2"></i>
                Weather Forecast Results
            `;

            // Update footer buttons
            const modalFooter = document.querySelector('#weatherCheckModal .modal-footer');
            modalFooter.innerHTML = `
                <button type="button" class="btn btn-secondary" onclick="showWeatherCheckModal()">
                    <i class="fas fa-arrow-left me-1"></i>
                    Check Another Location
                </button>
                <button type="button" class="btn btn-info" data-bs-dismiss="modal">
                    <i class="fas fa-check me-1"></i>
                    Done
                </button>
            `;
        }

        // Reset weather button state
        function resetWeatherButton() {
            const btn = document.getElementById('getWeatherBtn');
            if (btn) {
                btn.innerHTML = '<i class="fas fa-search me-1"></i>Get Weather Forecast';
                btn.disabled = false;
            }
        }

        // View locations function
        function viewLocations() {
            fetch('/api/weather/locations')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showLocationsModal(data.data.locations);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to load locations');
                });
        }

        // Show locations in a professional modal
        function showLocationsModal(locations) {
            // Create modal HTML
            const modalHtml = `
                <div class="modal fade" id="locationsModal" tabindex="-1" aria-labelledby="locationsModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title" id="locationsModalLabel">
                                    <i class="fas fa-map-marker-alt me-2"></i>
                                    Available Provinces in Indonesia
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <input type="text" class="form-control" id="locationSearch" placeholder="Search provinces..." onkeyup="filterLocations()">
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover" id="locationsTable">
                                        <thead class="table-dark">
                                            <tr>
                                                <th width="15%">Province ID</th>
                                                <th width="85%">Province Name</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            ${Object.entries(locations).map(([id, name]) => `
                                                <tr>
                                                    <td><span class="badge bg-secondary">${id}</span></td>
                                                    <td>${name}</td>
                                                </tr>
                                            `).join('')}
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mt-3">
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Total: <strong>${Object.keys(locations).length}</strong> provinces available for weather forecasting
                                    </small>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    <i class="fas fa-times me-1"></i>
                                    Close
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            // Remove existing modal if any
            const existingModal = document.getElementById('locationsModal');
            if (existingModal) {
                existingModal.remove();
            }

            // Add modal to body
            document.body.insertAdjacentHTML('beforeend', modalHtml);

            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('locationsModal'));
            modal.show();

            // Clean up when modal is hidden
            document.getElementById('locationsModal').addEventListener('hidden.bs.modal', function () {
                this.remove();
            });
        }

        // Filter locations table
        function filterLocations() {
            const input = document.getElementById('locationSearch');
            const filter = input.value.toLowerCase();
            const table = document.getElementById('locationsTable');
            const rows = table.getElementsByTagName('tr');

            for (let i = 1; i < rows.length; i++) {
                const cells = rows[i].getElementsByTagName('td');
                let found = false;
                
                for (let j = 0; j < cells.length; j++) {
                    if (cells[j].textContent.toLowerCase().indexOf(filter) > -1) {
                        found = true;
                        break;
                    }
                }
                
                rows[i].style.display = found ? '' : 'none';
            }
        }

        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);
    </script>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH D:\rama\persolkelly\hitachi_web_developer\outdoor-activity-scheduler\resources\views/layouts/app.blade.php ENDPATH**/ ?>