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

## User management

* The search include only active users with the role Person (`person`)
* We use [the Profile module](https://www.drupal.org/project/profile) to add fields to people.
* Users with the role Person manager (`person_manager`) can approve people and create new people.

## Github pages for Docs

We use Github Pages to create a static site for our documentation.

### Documentation in `/docs`

The documentation site will be created from the `/docs` folder.
