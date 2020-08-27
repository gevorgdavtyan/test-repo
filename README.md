## How deploy

### Add the DB Credentials

Next make sure to create a new database and add your database credentials to your .env file:

```
DB_HOST=localhost
DB_DATABASE=homestead
DB_USERNAME=homestead
DB_PASSWORD=secret
```

### Run The Installer

```
composer install
php artisan migrate --seed
```
