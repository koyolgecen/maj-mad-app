release: php bin/console cache:clear && php bin/console cache:warmup && php bin/console doctrine:migrations:migrate && php bin/console doctrine:fixtures:load
web: heroku-php-apache2 public/