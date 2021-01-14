release: php bin/console cache:clear && php bin/console cache:warmup && php bin/console doctrine:migrations:migrate -q && php bin/console doctrine:fixtures:load -q
web: heroku-php-apache2 public/