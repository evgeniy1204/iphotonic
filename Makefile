php-fpm-container=iphotonic-php-fpm

make-migration:
	docker exec -it $(php-fpm-container) php bin/console d:m:m --no-interaction
	docker exec -it $(php-fpm-container) php bin/console make:migration --no-interaction