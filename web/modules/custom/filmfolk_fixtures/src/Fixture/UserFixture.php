<?php

namespace Drupal\filmfolk_fixtures\Fixture;

use Drupal\content_fixtures\Fixture\AbstractFixture;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\user\RoleInterface;
use Drupal\user\RoleStorageInterface;
use Drupal\user\UserInterface;
use Drupal\user\UserStorageInterface;

/**
 * User fixture.
 */
class UserFixture extends AbstractFixture {

  /**
   * The role storage.
   */
  private readonly RoleStorageInterface $roleStorage;

  /**
   * The user storage.
   */
  private readonly UserStorageInterface $userStorage;

  public function __construct(
    EntityTypeManagerInterface $entityTypeManager,
  ) {
    $this->roleStorage = $entityTypeManager->getStorage('user_role');
    $this->userStorage = $entityTypeManager->getStorage('user');
  }

  /**
   * {@inheritdoc}
   *
   * Create a user for all roles with a few exceptions.
   */
  #[\Override]
  public function load() {
    $roles = $this->getRoles();
    foreach ($roles as $role) {
      $roleId = $role->id();
      $this
        ->createUser()
        ->setEmail($roleId . '@example.com')
        ->setUsername($roleId)
        ->addRole($roleId)
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

  /**
   * Get almost all roles.
   *
   * @return \Drupal\user\RoleInterface[]
   *   The roles.
   */
  private function getRoles(): array {
    return array_filter(
      $this->roleStorage->loadMultiple(),
      static fn(RoleInterface $role): bool => !in_array($role->id(), [
        // Roles that cannot be assigned.
        RoleInterface::AUTHENTICATED_ID,
        RoleInterface::ANONYMOUS_ID,
        // Role handled by PersonFixture.
        PersonFixture::ROLE_PERSON_ID,
      ])
    );
  }

}
