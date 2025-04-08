<?php

namespace Drupal\filmfolk_fixtures\Fixture;

use Drupal\content_fixtures\Fixture\AbstractFixture;
use Drupal\content_fixtures\Fixture\DependentFixtureInterface;
use Drupal\user\Entity\User;

/**
 * User fixture.
 */
final class UserFixture extends AbstractFixture implements DependentFixtureInterface {

  /**
   *
   */
  public function load() {
    $user = User::create([
      'mail' => 'user@example.com',
      'field_navn' => 'Navn Navnesen',
      'field_kommune' => $this->getReference('kommune:Aarhus'),
      'field_funktion' => [
        $this->getReference('funktion:Runner'),
        $this->getReference('funktion:Scenograf'),
      ],
      'field_description' => [
        'value' => '<strong>Hej</strong> med dig',
        'format' => 'simple',
      ],
    ])
      ->activate();
    $user->save();

    $user = User::create([
      'mail' => 'user002@example.com',
      'field_navn' => 'Navn Navnesen',
      'field_kommune' => $this->getReference('kommune:Herning'),
      'field_funktion' => [
        $this->getReference('funktion:Runner'),
        $this->getReference('funktion:Scenograf'),
      ],
      'field_description' => [
        'value' => 'Hvor\' du fra? Jeg\' fra <strong>Baune!</strong>',
        'format' => 'simple',
      ],
    ])
      ->activate();
    $user->save();

    $user = User::create([
      'mail' => 'user1@example.com',
      'field_kommune' => $this->getReference('kommune:Aarhus'),
    ]);
    $user->save();
  }

  /**
   *
   */
  public function getDependencies() {
    return [
      KommuneTermFixture::class,
      FunktionTermFixture::class,
    ];
  }

}
