Before getting started, ensure that you have the following installed on your system:

- PHP 8.2 (cli) or higher
- Composer
- MySQL or PostgreSQL
- Web server (e.g. Apache or Nginx)

Change into the project directory:

```
cd laravel-11-frame/
```

Build the Docker images:

```
docker-compose build
```

Enter to the web container:
```
docker-compose exec app bash
```

Install PHP dependencies:
```
composer install
```

Generate an application key:
```
php artisan key:generate
```

Change Permission:
```
chmod -R 777 bootstrap/cache	
chmod -R 777 storage/	
```

App Url:
```
http://localhost
```

DB Url:
```
http://localhost:8083
```
