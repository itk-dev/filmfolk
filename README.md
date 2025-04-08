# Filmfolk

``` shell name=install
docker network create frontend || true
docker compose pull
docker compose up --detach --remove-orphans --wait
docker compose exec phpfpm composer install
docker compose exec phpfpm vendor/bin/drush site:install --existing-config --yes
docker compose exec phpfpm vendor/bin/drush user:login
```

``` shell name=fixtures-load
docker compose exec phpfpm vendor/bin/drush --yes pm:install filmfolk_fixtures
docker compose exec phpfpm vendor/bin/drush --yes content-fixtures:load

docker compose exec phpfpm vendor/bin/drush search-api:reset-tracker
docker compose exec phpfpm vendor/bin/drush search-api:index
```
