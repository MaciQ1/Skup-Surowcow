C:\xampp\mysql\bin\mysql -uroot -e "CREATE DATABASE IF NOT EXISTS materials_purchase;"

if %errorlevel% neq 0 msg %username% "Nie udalo sie utworzyc bazy danych." && exit /b %errorlevel%

php -r "copy('.env.example', '.env');"

call composer install

call php artisan migrate:fresh --seed

call php artisan key:generate

call php artisan storage:link

code .