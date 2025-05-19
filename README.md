## Docker Installation

### Prerequisites

Before getting started, ensure that you have the following installed on your system:

- Docker
- Docker Compose

Clone the repository:

```
git clone https://github.com/Saw-Kyaw-Myint/laravel-11-frame.git
```

Change into the project directory:

```
cd laravel-11-frame
```

Setup formatter to format before commit:

```
cp src/pre-commit .git/hooks/pre-commit
```

Build the Docker images:

```
docker-compose build
```

Start the Docker containers:

```
docker-compose up -d
```

Install PHP dependencies:

```
docker-compose run --rm composer install
```

Install Node dependencies:

```
docker-compose run --rm npm install
```

Create a copy of the .env file::

```
cp .env.example .env
```

Generate an application key:

```
docker-compose run --rm artisan key:generate
```

Create a database and update your database connection details in `.env` file

```
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_api
DB_USERNAME=root
DB_PASSWORD=root
```

Run database migrations:

```
docker-compose run --rm artisan migrate
```

Run database seeder:

```
docker-compose run --rm artisan db:seed
```

The project should now be running at (close your apache service due to duplicate port)
 http://localhost.

 phpMyAdmin is running at
 http://localhost:8090