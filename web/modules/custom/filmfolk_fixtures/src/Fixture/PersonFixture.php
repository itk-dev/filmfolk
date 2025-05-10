<?php

namespace Drupal\filmfolk_fixtures\Fixture;

use Drupal\content_fixtures\Fixture\DependentFixtureInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\filmfolk\Plugin\Field\FieldType\FunktionErfaringItem;
use Drupal\taxonomy\TermStorageInterface;
use Drupal\user\UserInterface;

/**
 * Person fixture.
 */
final class PersonFixture extends UserFixture implements DependentFixtureInterface {
  const ROLE_PERSON_ID = 'person';

  /**
   * The term storage.
   */
  private TermStorageInterface $taxonomyTermStorage;

  public function __construct(EntityTypeManagerInterface $entityTypeManager) {
    parent::__construct($entityTypeManager);
    $this->taxonomyTermStorage = $entityTypeManager->getStorage('taxonomy_term');
  }

  /**
   * {@inheritdoc}
   */
  #[\Override]
  public function load() {

    // Get the pre-created media entity using the reference key we set.
    $default_profile_picture_media = $this->getReference('media:profile_picture:default');

    $user = $this->createUser([
      'mail' => 'person@example.com',
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

    $user = $this->createUser([
      'mail' => 'person002@example.com',
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

    $user = $this->createUser([
      'mail' => 'person003@example.com',
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

    $user = $this->createUser([
      'mail' => 'person004@example.com',
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

    $user = $this->createUser([
      'mail' => 'person005@example.com',
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

    $user = $this->createUser([
      'mail' => 'person006@example.com',
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

    $user = $this->createUser([
      'mail' => 'person1@example.com',
      'field_kommune' => $this->getReference('kommune:Aarhus'),
    ]);
    $user->save();

    $this->createPersonsWithAllFunktionerAndExperiences();
  }

  /**
   * {@inheritdoc}
   */
  protected function createUser(array $values = []): UserInterface {
    return parent::createUser($values)
      ->addRole(self::ROLE_PERSON_ID);
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

  /**
   * Create persons with all funktioner and experiences.
   */
  private function createPersonsWithAllFunktionerAndExperiences() {
    /** @var \Drupal\taxonomy\TermInterface[] $funktions */
    $funktions = $this->taxonomyTermStorage->loadTree(FunktionTermFixture::$vocabularyId, load_entities: TRUE);
    /** @var \Drupal\taxonomy\TermInterface[] $erfarings */
    $erfarings = $this->taxonomyTermStorage->loadTree(ErfaringTermFixture::$vocabularyId, load_entities: TRUE);
    foreach ($funktions as $funktion) {
      foreach ($erfarings as $erfaring) {
        $this->createUser([
          'mail' => sprintf('person-f%d-e%d@example.com', $funktion->id(), $erfaring->id()),
          'field_navn' => sprintf('Person %s %s', $funktion->label(), $erfaring->label()),
          'field_kommune' => $this->getReference('kommune:Aarhus'),
          'field_funktion_erfaring' => [
            [
              // Important: We must use “…_TARGET_ID” to make this work.
              FunktionErfaringItem::PROPERTY_FUNKTION_TARGET_ID => $funktion->id(),
              FunktionErfaringItem::PROPERTY_ERFARING_TARGET_ID => $erfaring->id(),
            ],
          ],
        ])
          ->activate()
          ->save();
      }
    }
  }

}
