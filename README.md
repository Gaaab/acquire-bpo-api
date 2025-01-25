# Backend Configuration Setup

## Requirements
- [**Laravel Sail**](https://laravel.com/docs/11.x/sail)
- [**Docker**](https://www.docker.com/)

### Default Server Application Port
Feel free to update the application port ``8000``
http://localhost:8000/api/documentation
```env
APP_PORT=8000
```

## Commands

### Starting the Laravel Sail Docker Container
```bash
./vendor/bin/sail up
```

### Database Configuration
Update the `.env` file with the following database settings:

```env
DB_CONNECTION=pgsql
DB_HOST=pgsql
DB_PORT=5432
DB_DATABASE={your_database}
DB_USERNAME=sail
DB_PASSWORD=password
```

Replace `{your_database}` with the name of your database.

### Installing Laravel Passport Keys
```bash
php artisan passport:keys
```

### Running Database Seeders
```bash
# Create the dataase tables
php artisan migrate

# Populate the database tables
php artisan db:seed
```

### Testing
To run tests for the `CustomerService` class, use the following command:

```bash
./vendor/bin/sail artisan test
```

Take note: After running the test it also refreshes the database so make sure to repopulate again using the ``php artisan db:seed`` command.

### Documentation
You can access the api documentation here
http://localhost:8000/api/documentation

If ever the route does not exists please ensure that the OpenApi is genereted properly

Run the following commands to fix

```bash
php artisan l5-swagger:generate
php artisan optimize
```
