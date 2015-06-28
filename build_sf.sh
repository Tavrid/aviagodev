echo $PWD
php ./app/console cache:clear --env=prod
php ./app/console assets:install
php ./app/console assetic:dump --env=prod
#gulp run gulp from console
php ./app/console cache:clear --env=prod