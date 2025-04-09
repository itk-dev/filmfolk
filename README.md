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

## Taxonomies

We use a custom taxonomy term class (`Drupal\filmfolk\Entity\Term`) to control the term label; see
[`EntityEventSubscriber.php`](web/modules/custom/filmfolk/src/EventSubscriber/EntityEventSubscriber.php) and
[`Term.php`](web/modules/custom/filmfolk/src/Entity/Term.php) for details.

To make this work, i.e. not break editing terms, we apply [a patch](patches/drupal/core/term-name.patch) lifted from
<https://www.drupal.org/project/drupal/issues/3223302> to the core `Term` class.
