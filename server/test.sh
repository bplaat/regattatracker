# Run all unit tests
php artisan migrate:fresh
php artisan db:seed --class=TestSeeder
php artisan test
