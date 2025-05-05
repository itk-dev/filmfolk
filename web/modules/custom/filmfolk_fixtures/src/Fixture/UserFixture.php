<?php

namespace Drupal\filmfolk_fixtures\Fixture;

use Drupal\content_fixtures\Fixture\AbstractFixture;
use Drupal\content_fixtures\Fixture\DependentFixtureInterface;
use Drupal\filmfolk\Plugin\Field\FieldType\FunktionErfaringItem;
use Drupal\user\Entity\User;

/**
 * User fixture.
 */
final class UserFixture extends AbstractFixture implements DependentFixtureInterface {

  /**
   * {@inheritdoc}
   */
  #[\Override]
  public function load() {

    // Get the pre-created media entity using the reference key we set.
    $default_profile_picture_media = $this->getReference('media:profile_picture:default');

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
      // Reference the media entity here.
      'field_profile_picture' => [
        'target_id' => $default_profile_picture_media->id(),
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
      'field_funktion_erfaring' => [
        [
          // Important: We must use “…_TARGET_ID” to make this work.
          FunktionErfaringItem::PROPERTY_FUNKTION_TARGET_ID => $this->getReference('funktion:Runner')->id(),
          FunktionErfaringItem::PROPERTY_ERFARING_TARGET_ID => $this->getReference('erfaring:7 produktioner')->id(),
        ],
        [
          FunktionErfaringItem::PROPERTY_FUNKTION_TARGET_ID => $this->getReference('funktion:Advokat')->id(),
          FunktionErfaringItem::PROPERTY_ERFARING_TARGET_ID => $this->getReference('erfaring:1 produktion')->id(),
        ],
      ],
      'field_description' => [
        'value' => 'Hvor\' du fra? Jeg\' fra <strong>Baune!</strong>',
        'format' => 'simple',
      ],
    ])
      ->activate();
    $user->save();

    $user = User::create([
      'mail' => 'user003@example.com',
      'field_navn' => 'Navn Navnesen',
      'field_kommune' => $this->getReference('kommune:Herning'),
      'field_funktion' => [
        $this->getReference('funktion:Runner'),
        $this->getReference('funktion:Scenograf'),
      ],
      'field_funktion_erfaring' => [
        [
          // Important: We must use “…_TARGET_ID” to make this work.
          FunktionErfaringItem::PROPERTY_FUNKTION_TARGET_ID => $this->getReference('funktion:Runner')->id(),
          FunktionErfaringItem::PROPERTY_ERFARING_TARGET_ID => $this->getReference('erfaring:7 produktioner')->id(),
        ],
        [
          FunktionErfaringItem::PROPERTY_FUNKTION_TARGET_ID => $this->getReference('funktion:Advokat')->id(),
          FunktionErfaringItem::PROPERTY_ERFARING_TARGET_ID => $this->getReference('erfaring:1 produktion')->id(),
        ],
      ],
      'field_description' => [
        'value' => 'Hvor\' du fra? Jeg\' fra <strong>Baune!</strong>',
        'format' => 'simple',
      ],
    ])
      ->activate();
    $user->save();

    $user = User::create([
      'mail' => 'user004@example.com',
      'field_navn' => 'Navn Navnesen',
      'field_kommune' => $this->getReference('kommune:Herning'),
      'field_funktion' => [
        $this->getReference('funktion:Runner'),
        $this->getReference('funktion:Scenograf'),
      ],
      'field_funktion_erfaring' => [
        [
          // Important: We must use “…_TARGET_ID” to make this work.
          FunktionErfaringItem::PROPERTY_FUNKTION_TARGET_ID => $this->getReference('funktion:Runner')->id(),
          FunktionErfaringItem::PROPERTY_ERFARING_TARGET_ID => $this->getReference('erfaring:7 produktioner')->id(),
        ],
        [
          FunktionErfaringItem::PROPERTY_FUNKTION_TARGET_ID => $this->getReference('funktion:Advokat')->id(),
          FunktionErfaringItem::PROPERTY_ERFARING_TARGET_ID => $this->getReference('erfaring:1 produktion')->id(),
        ],
      ],
      'field_description' => [
        'value' => 'Hvor\' du fra? Jeg\' fra <strong>Baune!</strong>',
        'format' => 'simple',
      ],
    ])
      ->activate();
    $user->save();

    $user = User::create([
      'mail' => 'user005@example.com',
      'field_navn' => 'Navn Navnesen',
      'field_kommune' => $this->getReference('kommune:Herning'),
      'field_funktion' => [
        $this->getReference('funktion:Runner'),
        $this->getReference('funktion:Scenograf'),
      ],
      'field_funktion_erfaring' => [
        [
          // Important: We must use “…_TARGET_ID” to make this work.
          FunktionErfaringItem::PROPERTY_FUNKTION_TARGET_ID => $this->getReference('funktion:Runner')->id(),
          FunktionErfaringItem::PROPERTY_ERFARING_TARGET_ID => $this->getReference('erfaring:7 produktioner')->id(),
        ],
        [
          FunktionErfaringItem::PROPERTY_FUNKTION_TARGET_ID => $this->getReference('funktion:Advokat')->id(),
          FunktionErfaringItem::PROPERTY_ERFARING_TARGET_ID => $this->getReference('erfaring:1 produktion')->id(),
        ],
      ],
      'field_description' => [
        'value' => 'Hvor\' du fra? Jeg\' fra <strong>Baune!</strong>',
        'format' => 'simple',
      ],
    ])
      ->activate();
    $user->save();

    $user = User::create([
      'mail' => 'user006@example.com',
      'field_navn' => 'Navn Navnesen',
      'field_kommune' => $this->getReference('kommune:Herning'),
      'field_funktion' => [
        $this->getReference('funktion:Runner'),
        $this->getReference('funktion:Scenograf'),
      ],
      'field_funktion_erfaring' => [
        [
          // Important: We must use “…_TARGET_ID” to make this work.
          FunktionErfaringItem::PROPERTY_FUNKTION_TARGET_ID => $this->getReference('funktion:Runner')->id(),
          FunktionErfaringItem::PROPERTY_ERFARING_TARGET_ID => $this->getReference('erfaring:7 produktioner')->id(),
        ],
        [
          FunktionErfaringItem::PROPERTY_FUNKTION_TARGET_ID => $this->getReference('funktion:Advokat')->id(),
          FunktionErfaringItem::PROPERTY_ERFARING_TARGET_ID => $this->getReference('erfaring:1 produktion')->id(),
        ],
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
   * {@inheritdoc}
   */
  #[\Override]
  public function getDependencies() {
    return [
      ProfilePictureFixture::class,
      KommuneTermFixture::class,
      FunktionTermFixture::class,
    ];
  }

}
