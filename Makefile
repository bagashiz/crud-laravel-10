mysql:
	podman run -h db --name mysql-laravel10 -p 3306:3306 -e MYSQL_ROOT_PASSWORD=password -d mysql:8.0
	
createdb:
	podman exec -ti mysql-laravel10 mysql -u root -ppassword -e "CREATE DATABASE db_laravel_10"

dropdb:
	podman exec -ti mysql-laravel10 mysql -u root -ppassword -e "DROP DATABASE db_laravel_10"

migrate:
	php artisan migrate

serve:
	php artisan serve

.PHONY: mysql createdb dropdb migrate serve
