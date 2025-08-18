# Setup Guide - Outdoor Activity Scheduler

This guide will help you set up and run the Outdoor Activity Scheduler application on your local machine.

## Prerequisites

Before you begin, ensure you have the following installed:

- **PHP 8.2 or higher**
- **Composer** (PHP dependency manager)
- **MySQL 8.0 or higher**
- **Web server** (Apache/Nginx) or use Laravel's built-in server

## Step-by-Step Installation

### 1. Download the Project

Extract the project files to your desired directory:
```bash
cd /path/to/your/projects
# Extract the outdoor-activity-scheduler folder here
```

### 2. Install PHP Dependencies

Navigate to the project directory and install dependencies:

```bash
cd outdoor-activity-scheduler
composer install
```

If you encounter network issues, try:
```bash
composer install --no-dev --optimize-autoloader
```

### 3. Environment Configuration

Copy the environment configuration file:
```bash
cp .env.example .env
```

Edit the `.env` file with your specific settings:

```env
# Application Settings
APP_NAME="Outdoor Activity Scheduler"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_TIMEZONE=Asia/Jakarta
APP_URL=http://localhost:8000

# Database Configuration
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=outdoor_activity_scheduler
DB_USERNAME=root
DB_PASSWORD=your_mysql_password

# BMKG API Configuration
BMKG_API_BASE_URL=https://data.bmkg.go.id/DataMKG/MEWS/DigitalForecast/
```

### 4. Generate Application Key

Generate a unique application key:
```bash
php artisan key:generate
```

### 5. Database Setup

#### Create Database

Log into MySQL and create the database:
```sql
CREATE DATABASE outdoor_activity_scheduler CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

#### Run Migrations

Create the database tables:
```bash
php artisan migrate
```

If you encounter any issues, you can also run:
```bash
php artisan migrate:fresh
```

### 6. Create Required Directories

Ensure all required directories exist and have proper permissions:

```bash
# Create storage directories
mkdir -p storage/app/public
mkdir -p storage/framework/cache
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/logs

# Create bootstrap cache directory
mkdir -p bootstrap/cache

# Set permissions (Linux/Mac)
chmod -R 755 storage
chmod -R 755 bootstrap/cache
```

For Windows, ensure the directories are writable by the web server.

### 7. Start the Application

#### Option A: Laravel Development Server (Recommended for testing)

```bash
php artisan serve
```

The application will be available at: `http://localhost:8000`

#### Option B: Using a Web Server

Configure your web server to point to the `public` directory of the project.

**Apache Virtual Host Example:**
```apache
<VirtualHost *:80>
    DocumentRoot /path/to/outdoor-activity-scheduler/public
    ServerName outdoor-scheduler.local
    
    <Directory /path/to/outdoor-activity-scheduler/public>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

**Nginx Configuration Example:**
```nginx
server {
    listen 80;
    server_name outdoor-scheduler.local;
    root /path/to/outdoor-activity-scheduler/public;
    
    index index.php;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

## Testing the Installation

### 1. Access the Web Interface

Open your browser and navigate to:
- `http://localhost:8000` (if using Laravel server)
- `http://outdoor-scheduler.local` (if using web server)

You should see the welcome page with the application dashboard.

### 2. Test API Endpoints

Test the API using curl or a tool like Postman:

```bash
# Test weather locations endpoint
curl http://localhost:8000/api/weather/locations

# Test weather suggestions
curl "http://localhost:8000/api/weather/suggestions?location=Jakarta&date=2024-01-20"

# Test activities endpoint
curl http://localhost:8000/api/activities
```

### 3. Create a Test Activity

1. Navigate to "New Activity" in the web interface
2. Fill in the form:
   - **Activity Name**: Test Field Survey
   - **Location**: DKI Jakarta
   - **Preferred Date**: Select tomorrow's date
   - **Sub-District**: Menteng (optional)
   - **Notes**: Test activity for verification

3. Click "Check Weather First" to see weather suggestions
4. Click "Create Activity" to save

## Troubleshooting

### Common Issues and Solutions

#### 1. "Class not found" errors
```bash
composer dump-autoload
```

#### 2. "Permission denied" errors
Ensure storage and bootstrap/cache directories are writable:
```bash
# Linux/Mac
chmod -R 755 storage bootstrap/cache

# Windows: Right-click folders → Properties → Security → Give full control to web server user
```

#### 3. Database connection errors
- Verify MySQL is running
- Check database credentials in `.env`
- Ensure the database exists
- Test connection: `php artisan tinker` then `DB::connection()->getPdo()`

#### 4. "Key not found" errors
```bash
php artisan key:generate
```

#### 5. Weather API not working
- Check internet connection
- Verify BMKG API is accessible
- The application will use mock data if the API is unavailable

#### 6. Blank page or 500 errors
- Check `storage/logs/laravel.log` for error details
- Ensure `APP_DEBUG=true` in `.env` for development
- Verify all required PHP extensions are installed

### Required PHP Extensions

Ensure these PHP extensions are installed:
- OpenSSL
- PDO
- Mbstring
- Tokenizer
- XML
- Ctype
- JSON
- BCMath
- Curl
- Fileinfo

Check with: `php -m`

## Development Setup

### Additional Development Tools

For development, you may want to install additional tools:

```bash
# Install development dependencies
composer install

# Install Laravel Pint for code formatting
./vendor/bin/pint

# Run tests (when available)
php artisan test
```

### Environment Configuration for Development

```env
APP_ENV=local
APP_DEBUG=true
LOG_LEVEL=debug

# Enable query logging
DB_LOG_QUERIES=true
```

## Production Deployment

### Optimization Commands

Before deploying to production:

```bash
# Install production dependencies only
composer install --optimize-autoloader --no-dev

# Cache configuration
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache

# Generate optimized autoloader
composer dump-autoload --optimize
```

### Production Environment

```env
APP_ENV=production
APP_DEBUG=false
LOG_LEVEL=error

# Use secure session settings
SESSION_SECURE_COOKIE=true
SESSION_HTTP_ONLY=true
```

## Features Overview

Once installed, you can use these features:

### Web Interface
- **Dashboard**: Overview of activities and quick stats
- **Activity Management**: Create, view, edit, and delete activities
- **Weather Integration**: Real-time weather suggestions
- **Responsive Design**: Works on desktop and mobile devices

### API Features
- **RESTful API**: Complete CRUD operations for activities
- **Weather API**: Get forecasts and suggestions
- **JSON Responses**: Structured API responses
- **Error Handling**: Proper HTTP status codes and error messages

### Weather Integration
- **BMKG Integration**: Real Indonesian weather data
- **Smart Suggestions**: Optimal time slot recommendations
- **Fallback System**: Mock data when API is unavailable
- **Multiple Locations**: Support for all Indonesian provinces

## Support

If you encounter issues:

1. Check the `storage/logs/laravel.log` file for error details
2. Verify all requirements are met
3. Ensure proper file permissions
4. Test database connectivity
5. Check the troubleshooting section above

## Next Steps

After successful installation:

1. Explore the web interface
2. Test the API endpoints
3. Create sample activities
4. Review the API documentation
5. Customize the application as needed

The application is now ready for use!