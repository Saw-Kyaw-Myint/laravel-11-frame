Before getting started, ensure that you have the following installed on your system:

- PHP 8.2 (cli) or higher
- Composer
- MySQL or PostgreSQL
- Web server (e.g. Apache or Nginx)

Clone the repository:

```
git clone https://github.com/Saw-Kyaw-Myint/laravel-11-frame.git
```

Change into the project directory:

```
cd laravel-11-frame/src
```

Setup formatter to format before commit:

```
cp pre-commit .git/hooks/pre-commit
```

Install PHP dependencies:

```
composer install
```

Run Devlopment Server
```
php artisan serve
```