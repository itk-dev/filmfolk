---
title: Development
parent: Filmfolk dokumentation
---

# Development

For development and testing, a couple of useful modules con be installed. The modules are [excluded from the
configuration synchronization](https://www.drupal.org/node/3079028).

## Drupal admin message

[The Drupal admin message module](https://github.com/itk-dev/drupal_admin_message) can show a message on admin pages:

``` shell
drush pm:install drupal_admin_message
```

See <https://github.com/itk-dev/drupal_admin_message/blob/main/README.md#configuration> for details on how to set up
admin messages

## Masquerade

[The Masquerade module](https://www.drupal.org/project/masquerade) makes it easy to switch between users during testing
(or bug hunting).

``` shell
drush pm:install masquerade
```

> [!TIP]
> If you're masquerading as a user that doesn't have access to the admin menu, go to `/unmasquerade` to unmasquerade.
