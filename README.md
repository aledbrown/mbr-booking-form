### Setup Information

- Laravel 11.x
- PHP 8.3
- SQLite

### Create an SQLite DB
- touch database/database.sqlite
- DB_CONNECTION=sqlite

### PEST Testing DB
- open phpunit.xml in project root directory
- Set env DB_CONNECTION to 'sqlite'
- DB_DATABASE to ':memory:'
- without the quotes
- these values are usually there but commented out

### Running Locally
- composer install
- php artisan serve
- npm run dev
- npm run build
