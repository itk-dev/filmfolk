<?php

namespace Drupal\filmfolk_fixtures\Fixture;

use Drupal\content_fixtures\Fixture\AbstractFixture;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\user\UserInterface;
use Drupal\user\UserStorageInterface;

/**
 * User fixture.
 */
class UserFixture extends AbstractFixture {

  /**
   * The user storage.
   */
  private readonly UserStorageInterface $userStorage;

  public function __construct(
    EntityTypeManagerInterface $entityTypeManager,
  ) {
    $this->userStorage = $entityTypeManager->getStorage('user');
  }

  /**
   * {@inheritdoc}
   */
  #[\Override]
  public function load() {
    $roles = ['editor', 'person_manager'];
    foreach ($roles as $role) {
      $this
        ->createUser()
        ->setEmail($role . '@example.com')
        ->setUsername($role)
        ->addRole($role)
        ->activate()
        ->save();
    }
  }

  /**
   * Create a user.
   */
  protected function createUser(array $values = []): UserInterface {
    return $this->userStorage->create($values);
  }

}
