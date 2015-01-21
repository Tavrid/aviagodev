rm app/cache/prod -r
php app/console assets:install
php app/console assetic:dump --env=prod
gulp
rm app/cache/prod -r