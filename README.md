# Filmfolk

We use [Task](https://taskfile.dev/).

## Development

``` shell name=site-install
task site-install
```

``` shell name=fixtures-load
task fixtures:load
```

``` shell name=site-update
task site-install
```

Run `task` to see a list of useful tasks.

## Taxonomies

We use a custom taxonomy term class (`Drupal\filmfolk\Entity\Term`) to control the term label; see
[`EntityEventSubscriber.php`](web/modules/custom/filmfolk/src/EventSubscriber/EntityEventSubscriber.php) and
[`Term.php`](web/modules/custom/filmfolk/src/Entity/Term.php) for details.

To make this work, i.e. not break editing terms, we apply [a patch](patches/drupal/core/term-name.patch) lifted from
<https://www.drupal.org/project/drupal/issues/3223302> to the core `Term` class.
