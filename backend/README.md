# Food Truck Tracker - Backend API

Laravel REST API for food truck tracking with admin dashboard.

## Features

- RESTful API for food truck CRUD operations
- SQLite database with seeded data
- CORS support for mobile app
- Admin dashboard for management

## Setup

### Prerequisites
- PHP 8.2+
- Composer

### Installation
```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
php artisan serve
```

API: `http://localhost:8000/api/food-trucks`
Admin: `http://localhost:8000/admin`

## API Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/food-trucks` | Get all food trucks |
| GET | `/api/food-trucks/{id}` | Get specific food truck |
| POST | `/api/food-trucks` | Create new food truck |
| PUT | `/api/food-trucks/{id}` | Update food truck |
| DELETE | `/api/food-trucks/{id}` | Delete food truck |

## Development

### Reset Database
```bash
php artisan migrate:fresh --seed
```

### Run Tests
```bash
php artisan test
```

## License
MIT License
```

**Add Sample Data:**
```bash
php artisan db:seed --class=FoodTruckSeeder
```

## Production Deployment

### Environment Variables

Ensure these are set in production:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com
DB_CONNECTION=sqlite
DB_DATABASE=/path/to/database.sqlite
```

### Optimization

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
composer install --no-dev --optimize-autoloader
```

## API Configuration

### CORS Setup

CORS is configured to allow requests from mobile applications. Update `config/cors.php` if needed:

```php
'allowed_origins' => ['*'],
'allowed_methods' => ['*'],
'allowed_headers' => ['*'],
```

### Rate Limiting

API endpoints are rate-limited to prevent abuse:
- 60 requests per minute for general endpoints
- Configurable in `app/Http/Kernel.php`

## Troubleshooting

### Common Issues

**Database Permission Error:**
```bash
chmod 755 database/
chmod 664 database/database.sqlite
```

**Storage Permission Error:**
```bash
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/
```

**Composer Memory Error:**
```bash
php -d memory_limit=-1 /usr/local/bin/composer install
```

### Health Check

Test API connectivity:
```bash
curl http://localhost:8000/api/food-trucks
```

### Logs

Check application logs:
```bash
tail -f storage/logs/laravel.log
```

## Architecture

- **Framework:** Laravel 11
- **Database:** SQLite (production-ready)
- **Authentication:** Stateless API (ready for token auth)
- **Caching:** File-based (configurable)
- **Queue:** Sync (upgradeable to Redis/SQS)

## Contributing

1. Follow PSR-12 coding standards
2. Write tests for new features
3. Update API documentation
4. Ensure database migrations are reversible

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
