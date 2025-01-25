# Backend Configuration Setup

## Requirements
- **Laravel Sail**
- **Docker**

### Default Application Port
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

### Testing
To run tests for the `CustomerService` class, use the following command:

```bash
./vendor/bin/sail artisan test
```
