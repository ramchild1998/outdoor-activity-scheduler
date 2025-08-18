# Outdoor Activity Scheduler

Aplikasi web berbasis Laravel untuk penjadwalan kegiatan outdoor dengan rekomendasi cuaca cerdas menggunakan data BMKG (Badan Meteorologi, Klimatologi, dan Geofisika).

## 📋 Daftar Isi

- [Fitur Utama](#fitur-utama)
- [Persyaratan Sistem](#persyaratan-sistem)
- [Instalasi](#instalasi)
- [Konfigurasi](#konfigurasi)
- [Penggunaan](#penggunaan)
- [API Documentation](#api-documentation)
- [Struktur Database](#struktur-database)
- [Teknologi yang Digunakan](#teknologi-yang-digunakan)
- [Testing](#testing)
- [Deployment](#deployment)
- [Troubleshooting](#troubleshooting)
- [Kontribusi](#kontribusi)
- [Lisensi](#lisensi)

## 🚀 Fitur Utama

### Frontend Features
- **Dashboard Interaktif**: Tampilan overview dengan statistik aktivitas dan navigasi yang mudah
- **Form Pembuatan Aktivitas**: Form lengkap dengan validasi untuk membuat kegiatan baru
- **Manajemen Aktivitas**: CRUD lengkap untuk mengelola aktivitas outdoor
- **Integrasi Cuaca**: Menampilkan prakiraan cuaca dan rekomendasi waktu optimal
- **Filter dan Pencarian**: Filter berdasarkan tanggal, status, dan lokasi
- **Responsive Design**: Tampilan yang optimal di desktop dan mobile

### Backend Features
- **Laravel 11**: Framework PHP modern dengan arsitektur MVC
- **RESTful API**: API lengkap untuk integrasi dengan sistem lain
- **Database Integration**: Penyimpanan data dengan MySQL
- **Weather Service**: Integrasi dengan API BMKG untuk data cuaca
- **Session Management**: Manajemen sesi pengguna yang aman
- **Caching System**: Sistem cache untuk performa optimal

### Weather Integration
- **Prakiraan 3 Hari**: Data cuaca untuk 3 hari ke depan
- **Rekomendasi Waktu**: Saran slot waktu optimal berdasarkan kondisi cuaca
- **34 Provinsi Indonesia**: Dukungan untuk seluruh provinsi di Indonesia
- **Data Real-time**: Integrasi dengan API BMKG untuk data terkini
- **Fallback System**: Sistem cadangan dengan mock data

## 💻 Persyaratan Sistem

- **PHP**: 8.2 atau lebih tinggi
- **Composer**: Package manager untuk PHP
- **MySQL**: 8.0 atau lebih tinggi
- **Web Server**: Apache/Nginx atau Laravel development server
- **Node.js**: (Opsional) untuk kompilasi asset
- **Git**: Untuk version control

### PHP Extensions yang Diperlukan
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

## 📦 Instalasi

### 1. Clone Repository

```bash
git clone <repository-url>
cd outdoor-activity-scheduler
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Konfigurasi Environment

```bash
cp .env.example .env
```

Edit file `.env` dengan konfigurasi Anda:

```env
APP_NAME="Outdoor Activity Scheduler"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_TIMEZONE=Asia/Jakarta
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=outdoor_activity_scheduler
DB_USERNAME=root
DB_PASSWORD=your_password

BMKG_API_BASE_URL=https://data.bmkg.go.id/DataMKG/MEWS/DigitalForecast/
```

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Setup Database

Buat database MySQL:

```sql
CREATE DATABASE outdoor_activity_scheduler CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Jalankan migrasi:

```bash
php artisan migrate
```

### 6. Jalankan Aplikasi

```bash
php artisan serve
```

Aplikasi akan tersedia di `http://localhost:8000`

## ⚙️ Konfigurasi

### Environment Variables

| Variable | Deskripsi | Default |
|----------|-----------|---------|
| `APP_NAME` | Nama aplikasi | Outdoor Activity Scheduler |
| `APP_TIMEZONE` | Timezone aplikasi | Asia/Jakarta |
| `DB_CONNECTION` | Koneksi database | mysql |
| `DB_DATABASE` | Nama database | outdoor_activity_scheduler |
| `BMKG_API_BASE_URL` | URL base API BMKG | https://data.bmkg.go.id/DataMKG/MEWS/DigitalForecast/ |

### Konfigurasi Cache dan Session

Aplikasi menggunakan database untuk session dan cache. Pastikan tabel sudah dibuat:

```bash
php artisan session:table
php artisan cache:table
php artisan migrate
```

## 🎯 Penggunaan

### Web Interface

#### 1. Dashboard
- Akses halaman utama di `http://localhost:8000`
- Lihat statistik aktivitas dan navigasi cepat
- Akses fitur utama melalui tombol navigasi

#### 2. Membuat Aktivitas Baru
1. Klik "Schedule New Activity" atau "New Activity"
2. Isi form dengan informasi berikut:
   - **Nama Aktivitas**: Deskripsi kegiatan (wajib)
   - **Tanggal Preferensi**: Tanggal yang diinginkan (wajib)
   - **Lokasi/Provinsi**: Pilih dari dropdown (wajib)
   - **Kecamatan**: Informasi kecamatan (opsional)
   - **Desa/Kelurahan**: Informasi desa (opsional)
   - **Catatan**: Informasi tambahan (opsional)
3. Klik "Check Weather First" untuk melihat rekomendasi cuaca
4. Klik "Create Activity" untuk menyimpan

#### 3. Mengelola Aktivitas
- **Lihat Daftar**: Akses `/activities` untuk melihat semua aktivitas
- **Filter**: Gunakan filter berdasarkan tanggal, status, atau lokasi
- **Detail**: Klik "View" untuk melihat detail dan prakiraan cuaca
- **Update Status**: Gunakan tombol "Schedule" atau "Mark as Scheduled"

#### 4. Prakiraan Cuaca
- Sistem menampilkan 4 slot waktu per hari (06:00, 12:00, 18:00, 00:00)
- Rekomendasi berdasarkan kondisi cuaca:
  - ✅ **Optimal**: Cerah, berawan sebagian (cocok untuk aktivitas outdoor)
  - ❌ **Tidak Optimal**: Hujan, badai (tidak cocok untuk aktivitas outdoor)

### Status Aktivitas

- **Pending**: Aktivitas baru yang belum dijadwalkan
- **Scheduled**: Aktivitas yang sudah dijadwalkan
- **Completed**: Aktivitas yang sudah selesai
- **Cancelled**: Aktivitas yang dibatalkan

## 🔌 API Documentation

### Base URL
```
http://localhost:8000/api
```

### Authentication
Saat ini API tidak memerlukan autentikasi. Untuk production, disarankan menambahkan autentikasi.

### Endpoints

#### Activities

##### GET /activities
Mendapatkan daftar aktivitas dengan pagination.

**Parameters:**
- `date` (optional): Filter berdasarkan tanggal (YYYY-MM-DD)
- `status` (optional): Filter berdasarkan status (pending, scheduled, completed, cancelled)
- `location` (optional): Filter berdasarkan lokasi
- `per_page` (optional): Jumlah item per halaman (default: 15)

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "name": "Field Survey",
      "location": "DKI Jakarta",
      "sub_district": "Menteng",
      "village": "Menteng Dalam",
      "preferred_date": "2025-08-19T17:00:00.000000Z",
      "selected_time_slot": null,
      "weather_condition": null,
      "status": "pending",
      "notes": "Survey lokasi untuk proyek baru",
      "created_at": "2025-08-18T12:50:23.000000Z",
      "updated_at": "2025-08-18T12:50:23.000000Z"
    }
  ],
  "pagination": {
    "current_page": 1,
    "last_page": 1,
    "per_page": 15,
    "total": 1,
    "from": 1,
    "to": 1
  }
}
```

##### POST /activities
Membuat aktivitas baru.

**Request Body:**
```json
{
  "name": "Field Survey",
  "location": "DKI Jakarta",
  "sub_district": "Menteng",
  "village": "Menteng Dalam",
  "preferred_date": "2025-08-19",
  "notes": "Survey lokasi untuk proyek baru"
}
```

**Response:**
```json
{
  "success": true,
  "message": "Activity created successfully",
  "data": {
    "id": 1,
    "name": "Field Survey",
    "location": "DKI Jakarta",
    "sub_district": "Menteng",
    "village": "Menteng Dalam",
    "preferred_date": "2025-08-19T17:00:00.000000Z",
    "notes": "Survey lokasi untuk proyek baru",
    "updated_at": "2025-08-18T12:50:23.000000Z",
    "created_at": "2025-08-18T12:50:23.000000Z"
  },
  "weather_suggestions": [
    {
      "datetime": "2025-08-19 06:00",
      "time": "06:00",
      "weather": "Clear",
      "weather_code": "0",
      "temperature": 25,
      "humidity": 70,
      "is_optimal": true,
      "recommendation": "Recommended"
    }
  ]
}
```

##### GET /activities/{id}
Mendapatkan detail aktivitas beserta saran cuaca.

##### PUT /activities/{id}
Mengupdate aktivitas.

##### DELETE /activities/{id}
Menghapus aktivitas.

#### Weather

##### GET /weather/locations
Mendapatkan daftar provinsi yang tersedia.

**Response:**
```json
{
  "success": true,
  "message": "Available locations retrieved successfully",
  "data": {
    "locations": {
      "31": "DKI Jakarta",
      "32": "Jawa Barat",
      "33": "Jawa Tengah",
      "34": "DI Yogyakarta",
      "35": "Jawa Timur"
    },
    "total": 34
  }
}
```

##### GET /weather/suggestions
Mendapatkan saran waktu optimal berdasarkan cuaca.

**Parameters:**
- `location` (required): Nama lokasi
- `date` (required): Tanggal (YYYY-MM-DD)
- `province_id` (optional): ID provinsi (default: 31 untuk Jakarta)

**Response:**
```json
{
  "success": true,
  "message": "Weather suggestions retrieved successfully",
  "data": {
    "location": "Jakarta",
    "date": "2025-08-19",
    "province_id": "31",
    "suggestions": [
      {
        "datetime": "2025-08-19 06:00",
        "time": "06:00",
        "weather": "Clear",
        "weather_code": "0",
        "temperature": 25,
        "humidity": 70,
        "is_optimal": true,
        "recommendation": "Recommended"
      }
    ],
    "optimal_count": 3,
    "total_slots": 4
  }
}
```

##### GET /weather/forecast
Mendapatkan prakiraan cuaca detail.

**Parameters:**
- `province_id` (required): ID provinsi
- `days` (optional): Jumlah hari prakiraan (1-7, default: 3)

## 🗄️ Struktur Database

### Tabel Activities

```sql
CREATE TABLE activities (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    location VARCHAR(255) NOT NULL,
    sub_district VARCHAR(255) NULL,
    village VARCHAR(255) NULL,
    preferred_date DATE NOT NULL,
    selected_time_slot DATETIME NULL,
    weather_condition VARCHAR(255) NULL,
    status ENUM('pending', 'scheduled', 'completed', 'cancelled') DEFAULT 'pending',
    notes TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    INDEX idx_preferred_date_status (preferred_date, status),
    INDEX idx_location (location)
);
```

### Tabel Sessions

```sql
CREATE TABLE sessions (
    id VARCHAR(255) PRIMARY KEY,
    user_id BIGINT UNSIGNED NULL,
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    payload LONGTEXT NOT NULL,
    last_activity INT NOT NULL,
    INDEX sessions_user_id_index (user_id),
    INDEX sessions_last_activity_index (last_activity)
);
```

### Tabel Cache

```sql
CREATE TABLE cache (
    key VARCHAR(255) PRIMARY KEY,
    value MEDIUMTEXT NOT NULL,
    expiration INT NOT NULL
);
```

## 🛠️ Teknologi yang Digunakan

### Backend
- **Laravel 11**: PHP framework dengan arsitektur MVC
- **PHP 8.2+**: Bahasa pemrograman server-side
- **MySQL 8.0+**: Database relasional
- **Guzzle HTTP**: HTTP client untuk API calls
- **Carbon**: Library untuk manipulasi tanggal dan waktu

### Frontend
- **Blade Templates**: Template engine Laravel
- **Bootstrap 5**: CSS framework untuk responsive design
- **jQuery**: JavaScript library untuk interaktivitas
- **Font Awesome**: Icon library
- **Google Fonts**: Web fonts

### Development Tools
- **Composer**: PHP dependency manager
- **Artisan**: Laravel command-line interface
- **Laravel Pint**: Code style fixer
- **PHPUnit**: Testing framework

## 🧪 Testing

### Menjalankan Tests

```bash
# Menjalankan semua tests
php artisan test

# Menjalankan tests dengan coverage
php artisan test --coverage

# Menjalankan specific test
php artisan test --filter=ActivityTest
```

### Manual Testing

#### Test API Endpoints

```bash
# Test locations endpoint
curl -X GET "http://localhost:8000/api/weather/locations"

# Test weather suggestions
curl -X GET "http://localhost:8000/api/weather/suggestions?location=Jakarta&date=2025-08-19"

# Test create activity
curl -X POST "http://localhost:8000/api/activities" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Test Activity",
    "location": "DKI Jakarta",
    "preferred_date": "2025-08-19",
    "notes": "Test notes"
  }'

# Test get activities
curl -X GET "http://localhost:8000/api/activities"
```

#### Test Web Interface

1. **Homepage**: Akses `http://localhost:8000`
2. **Create Activity**: Klik "Schedule New Activity"
3. **Activities List**: Klik "View Activities"
4. **Activity Details**: Klik "View" pada aktivitas
5. **Weather Integration**: Test "Check Weather First" button

## 🚀 Deployment

### Production Setup

#### 1. Environment Configuration

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

# Database production
DB_HOST=your-production-host
DB_DATABASE=your-production-db
DB_USERNAME=your-production-user
DB_PASSWORD=your-secure-password

# Cache dan Session
CACHE_DRIVER=database
SESSION_DRIVER=database
```

#### 2. Optimization Commands

```bash
# Install production dependencies
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

#### 3. File Permissions

```bash
# Set proper permissions
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

#### 4. Web Server Configuration

##### Apache Virtual Host

```apache
<VirtualHost *:80>
    DocumentRoot /path/to/outdoor-activity-scheduler/public
    ServerName your-domain.com
    
    <Directory /path/to/outdoor-activity-scheduler/public>
        AllowOverride All
        Require all granted
    </Directory>
    
    ErrorLog ${APACHE_LOG_DIR}/outdoor-scheduler-error.log
    CustomLog ${APACHE_LOG_DIR}/outdoor-scheduler-access.log combined
</VirtualHost>
```

##### Nginx Configuration

```nginx
server {
    listen 80;
    server_name your-domain.com;
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
    
    location ~ /\.ht {
        deny all;
    }
}
```

### SSL Configuration

```bash
# Install SSL certificate (Let's Encrypt)
sudo certbot --nginx -d your-domain.com
```

## 🔧 Troubleshooting

### Common Issues

#### 1. Database Connection Error

**Problem**: `SQLSTATE[HY000] [2002] Connection refused`

**Solution**:
```bash
# Check MySQL service
sudo systemctl status mysql
sudo systemctl start mysql

# Verify database credentials in .env
# Test connection
php artisan tinker
DB::connection()->getPdo();
```

#### 2. Permission Errors

**Problem**: `The stream or file could not be opened in append mode`

**Solution**:
```bash
# Fix permissions
sudo chmod -R 755 storage bootstrap/cache
sudo chown -R www-data:www-data storage bootstrap/cache
```

#### 3. Class Not Found Errors

**Problem**: `Class 'App\Http\Controllers\Controller' not found`

**Solution**:
```bash
# Regenerate autoloader
composer dump-autoload

# Clear cache
php artisan cache:clear
php artisan config:clear
```

#### 4. Weather API Not Working

**Problem**: Weather data tidak muncul

**Solution**:
- Check internet connection
- Verify BMKG API endpoint accessibility
- Check logs: `tail -f storage/logs/laravel.log`
- Aplikasi akan menggunakan mock data jika API tidak tersedia

#### 5. Session Issues

**Problem**: Session tidak tersimpan

**Solution**:
```bash
# Recreate session table
php artisan session:table
php artisan migrate

# Clear session cache
php artisan cache:clear
```

### Debug Mode

Untuk development, aktifkan debug mode:

```env
APP_DEBUG=true
LOG_LEVEL=debug
```

### Log Files

Check log files untuk debugging:

```bash
# Laravel logs
tail -f storage/logs/laravel.log

# Web server logs
tail -f /var/log/apache2/error.log  # Apache
tail -f /var/log/nginx/error.log    # Nginx
```

## 🤝 Kontribusi

### Development Workflow

1. Fork repository
2. Create feature branch: `git checkout -b feature/new-feature`
3. Make changes dan commit: `git commit -am 'Add new feature'`
4. Push ke branch: `git push origin feature/new-feature`
5. Submit Pull Request

### Coding Standards

- Follow PSR-12 coding standards
- Use Laravel best practices
- Write meaningful commit messages
- Add tests for new features
- Update documentation

### Code Style

```bash
# Format code dengan Laravel Pint
./vendor/bin/pint

# Check code style
./vendor/bin/pint --test
```

## 📄 Lisensi

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 📞 Support

Untuk pertanyaan dan dukungan:

- **Email**: support@outdoor-scheduler.com
- **Documentation**: [Wiki](https://github.com/your-repo/wiki)
- **Issues**: [GitHub Issues](https://github.com/your-repo/issues)
- **Discussions**: [GitHub Discussions](https://github.com/your-repo/discussions)

## 📈 Roadmap

### Version 1.1.0 (Planned)
- [ ] User authentication dan authorization
- [ ] Email notifications untuk aktivitas
- [ ] Export data ke PDF/Excel
- [ ] Mobile app (React Native)

### Version 1.2.0 (Planned)
- [ ] Multi-language support
- [ ] Advanced weather analytics
- [ ] Integration dengan Google Calendar
- [ ] Real-time notifications

### Version 2.0.0 (Future)
- [ ] Machine learning untuk prediksi cuaca
- [ ] Advanced reporting dan analytics
- [ ] Team collaboration features
- [ ] API rate limiting dan authentication

## 🙏 Acknowledgments

- **BMKG**: Untuk menyediakan data cuaca Indonesia
- **Laravel Community**: Untuk framework yang luar biasa
- **Bootstrap Team**: Untuk CSS framework yang responsive
- **Font Awesome**: Untuk icon library yang lengkap

---

**Dibuat dengan ❤️ untuk Hitachi Internal System Developer Test**

*Last updated: August 18, 2025*