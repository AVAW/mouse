setup:
	composer install
	bin/console doctrine:database:create --if-not-exists
	bin/console doctrine:migrations:migrate --no-interaction
