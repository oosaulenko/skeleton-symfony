### Run this if you are building a traditional web application
```composer require webapp```

### Setup xdebug with PhpStorm and Lando
https://docs.lando.dev/guides/lando-phpstorm.html

```
composer install
php bin/console doctrine:migrations:migrate
php bin/console assets:install
```