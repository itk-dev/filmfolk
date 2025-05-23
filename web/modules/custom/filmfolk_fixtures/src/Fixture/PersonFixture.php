<?php

namespace Drupal\filmfolk_fixtures\Fixture;

use Faker\Factory;
use Faker\Generator;
use Drupal\content_fixtures\Fixture\DependentFixtureInterface;
use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\filmfolk\Helper;
use Drupal\filmfolk\Plugin\Field\FieldType\FunktionErfaringItem;
use Drupal\profile\ProfileStorage;
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

  /**
   * The profile storage.
   */
  private ProfileStorage $profileStorage;

  /**
   * The faker generator.
   */
  private Generator $faker;

  public function __construct(EntityTypeManagerInterface $entityTypeManager) {
    parent::__construct($entityTypeManager);
    $this->taxonomyTermStorage = $entityTypeManager->getStorage('taxonomy_term');
    $this->profileStorage = $entityTypeManager->getStorage('profile');
    $this->faker = Factory::create('da');
  }

  /**
   * {@inheritdoc}
   */
  #[\Override]
  public function load() {
    // Get the pre-created media entity using the reference key we set.
    $default_person_picture_media = $this->getReference('media:profile_picture:default');

    $this->createPerson([
      'mail' => 'person@example.com',
      'status' => 1,
    ], [
      'field_person_name' => $this->faker->name(),
      'field_person_kommune' => $this->getReference('kommune:Aarhus'),
      'field_person_image' => [
        $this->getReference(ImageFileFixture::getImageReferenceName(0)),
      ],
      'field_person_title' => [
        'value' => $this->faker->text(48),
        'format' => 'simple',
      ],
      'field_person_education_interest' => [
        'value' => $this->faker->text(),
        'format' => 'simple',
      ],
      'field_person_about' => [
        'value' => $this->faker->text(),
        'format' => 'simple',
      ],
      'field_person_additional_info' => [
        'value' => $this->faker->text(),
        'format' => 'simple',
      ],
    ]);

    $this->createPerson([
      'mail' => 'person002@example.com',
      'status' => 1,
    ], [
      'field_person_navn' => 'Navn Navnesen',
      'field_person_kommune' => $this->getReference('kommune:Herning'),
      'field_person_funktion_erfaring' => [
            [
              // Important: We must use “…_TARGET_ID” to make this work.
              FunktionErfaringItem::PROPERTY_FUNKTION_TARGET_ID => $this->getReference('funktion:Runner')->id(),
              FunktionErfaringItem::PROPERTY_ERFARING_TARGET_ID => $this->getReference('erfaring:Nogen erfaring fra professionelle produktioner (5-10 produktioner)')->id(),
            ],
            [
              FunktionErfaringItem::PROPERTY_FUNKTION_TARGET_ID => $this->getReference('funktion:Animator')->id(),
              FunktionErfaringItem::PROPERTY_ERFARING_TARGET_ID => $this->getReference('erfaring:Lidt erfaring fra professionelle produktioner (1-4 produktioner)')->id(),
            ],
      ],
      'field_person_title' => [
        'value' => 'Kulturformidler | Forfatter | Underviser ved Horsens Professionshøjskole',
        'format' => 'simple',
      ],
      'field_person_education_interest' => [
        'value' => 'Kandidat i Nordiske Studier fra Horsens Universitet med speciale i moderne dansk litteratur. Efteruddannelse i kreativ skrivning fra Forfatterskolen. Forsker i folkeeventyr og mundtlige fortælletraditioner i Skandinavien.',
        'format' => 'simple',
      ],
      'field_person_about' => [
        'value' => 'Jeg har arbejdet med litteratur og kulturformidling i 20 år, først som bibliotekar og senere som forfatter og underviser. Min passion er at gøre dansk kulturarv tilgængelig for nye generationer gennem moderne fortælleformer. Jeg har udgivet tre romaner og en samling noveller, der alle er inspireret af nordisk mytologi og historie.',
        'format' => 'simple',
      ],
      'field_person_additional_info' => [
        'value' => 'Født og opvokset i Middelfart, nu bosiddende i Horsens. Bestyrelsesmedlem i Dansk Forfatterforening. Afholder skriveworkshops for unge og voksne. Aktiv i lokale litteraturklubber og kulturforeninger. I fritiden samler jeg på førsteoplag af H.C. Andersens eventyr og arrangerer litteraturvandringer i hovedstaden.',
        'format' => 'simple',
      ],
    ]);

    $this->createPerson([
      'mail' => 'person003@example.com',
      'status' => 1,
    ], [
      'field_person_navn' => 'Navn Navnesen',
      'field_person_kommune' => $this->getReference('kommune:Herning'),
      'field_person_funktion_erfaring' => [
            [
              // Important: We must use “…_TARGET_ID” to make this work.
              FunktionErfaringItem::PROPERTY_FUNKTION_TARGET_ID => $this->getReference('funktion:Runner')->id(),
              FunktionErfaringItem::PROPERTY_ERFARING_TARGET_ID => $this->getReference('erfaring:Nogen erfaring fra professionelle produktioner (5-10 produktioner)')->id(),
            ],
            [
              FunktionErfaringItem::PROPERTY_FUNKTION_TARGET_ID => $this->getReference('funktion:Animator')->id(),
              FunktionErfaringItem::PROPERTY_ERFARING_TARGET_ID => $this->getReference('erfaring:Lidt erfaring fra professionelle produktioner (1-4 produktioner)')->id(),
            ],
      ],
      'field_person_title' => [
        'value' => 'Kulturformidler | Forfatter | Underviser ved Horsens Professionshøjskole',
        'format' => 'simple',
      ],
      'field_person_education_interest' => [
        'value' => 'Kandidat i Nordiske Studier fra Horsens Universitet med speciale i moderne dansk litteratur. Efteruddannelse i kreativ skrivning fra Forfatterskolen. Forsker i folkeeventyr og mundtlige fortælletraditioner i Skandinavien.',
        'format' => 'simple',
      ],
      'field_person_about' => [
        'value' => 'Jeg har arbejdet med litteratur og kulturformidling i 20 år, først som bibliotekar og senere som forfatter og underviser. Min passion er at gøre dansk kulturarv tilgængelig for nye generationer gennem moderne fortælleformer. Jeg har udgivet tre romaner og en samling noveller, der alle er inspireret af nordisk mytologi og historie.',
        'format' => 'simple',
      ],
      'field_person_additional_info' => [
        'value' => 'Født og opvokset i Middelfart, nu bosiddende i Horsens. Bestyrelsesmedlem i Dansk Forfatterforening. Afholder skriveworkshops for unge og voksne. Aktiv i lokale litteraturklubber og kulturforeninger. I fritiden samler jeg på førsteoplag af H.C. Andersens eventyr og arrangerer litteraturvandringer i hovedstaden.',
        'format' => 'simple',
      ],
    ]);

    $this->createPerson([
      'mail' => 'person004@example.com',
      'status' => 1,
    ], [
      'field_person_navn' => 'Navn Navnesen',
      'field_person_kommune' => $this->getReference('kommune:Herning'),
      'field_person_funktion_erfaring' => [
            [
              // Important: We must use “…_TARGET_ID” to make this work.
              FunktionErfaringItem::PROPERTY_FUNKTION_TARGET_ID => $this->getReference('funktion:Runner')->id(),
              FunktionErfaringItem::PROPERTY_ERFARING_TARGET_ID => $this->getReference('erfaring:Nogen erfaring fra professionelle produktioner (5-10 produktioner)')->id(),
            ],
            [
              FunktionErfaringItem::PROPERTY_FUNKTION_TARGET_ID => $this->getReference('funktion:Animator')->id(),
              FunktionErfaringItem::PROPERTY_ERFARING_TARGET_ID => $this->getReference('erfaring:Lidt erfaring fra professionelle produktioner (1-4 produktioner)')->id(),
            ],
      ],
      'field_person_title' => [
        'value' => 'Kulturformidler | Forfatter | Underviser ved Horsens Professionshøjskole',
        'format' => 'simple',
      ],
      'field_person_education_interest' => [
        'value' => 'Kandidat i Nordiske Studier fra Horsens Universitet med speciale i moderne dansk litteratur. Efteruddannelse i kreativ skrivning fra Forfatterskolen. Forsker i folkeeventyr og mundtlige fortælletraditioner i Skandinavien.',
        'format' => 'simple',
      ],
      'field_person_about' => [
        'value' => 'Jeg har arbejdet med litteratur og kulturformidling i 20 år, først som bibliotekar og senere som forfatter og underviser. Min passion er at gøre dansk kulturarv tilgængelig for nye generationer gennem moderne fortælleformer. Jeg har udgivet tre romaner og en samling noveller, der alle er inspireret af nordisk mytologi og historie.',
        'format' => 'simple',
      ],
      'field_person_additional_info' => [
        'value' => 'Født og opvokset i Middelfart, nu bosiddende i Horsens. Bestyrelsesmedlem i Dansk Forfatterforening. Afholder skriveworkshops for unge og voksne. Aktiv i lokale litteraturklubber og kulturforeninger. I fritiden samler jeg på førsteoplag af H.C. Andersens eventyr og arrangerer litteraturvandringer i hovedstaden.',
        'format' => 'simple',
      ],
    ]);

    $this->createPerson([
      'mail' => 'person005@example.com',
    ], [
      'field_person_navn' => 'Navn Navnesen',
      'field_person_kommune' => $this->getReference('kommune:Herning'),
      'field_person_funktion_erfaring' => [
            [
              // Important: We must use “…_TARGET_ID” to make this work.
              FunktionErfaringItem::PROPERTY_FUNKTION_TARGET_ID => $this->getReference('funktion:Runner')->id(),
              FunktionErfaringItem::PROPERTY_ERFARING_TARGET_ID => $this->getReference('erfaring:Nogen erfaring fra professionelle produktioner (5-10 produktioner)')->id(),
            ],
            [
              FunktionErfaringItem::PROPERTY_FUNKTION_TARGET_ID => $this->getReference('funktion:Animator')->id(),
              FunktionErfaringItem::PROPERTY_ERFARING_TARGET_ID => $this->getReference('erfaring:Lidt erfaring fra professionelle produktioner (1-4 produktioner)')->id(),
            ],
      ],
      'field_person_title' => [
        'value' => 'Kulturformidler | Forfatter | Underviser ved Horsens Professionshøjskole',
        'format' => 'simple',
      ],
      'field_person_education_interest' => [
        'value' => 'Kandidat i Nordiske Studier fra Horsens Universitet med speciale i moderne dansk litteratur. Efteruddannelse i kreativ skrivning fra Forfatterskolen. Forsker i folkeeventyr og mundtlige fortælletraditioner i Skandinavien.',
        'format' => 'simple',
      ],
      'field_person_about' => [
        'value' => 'Jeg har arbejdet med litteratur og kulturformidling i 20 år, først som bibliotekar og senere som forfatter og underviser. Min passion er at gøre dansk kulturarv tilgængelig for nye generationer gennem moderne fortælleformer. Jeg har udgivet tre romaner og en samling noveller, der alle er inspireret af nordisk mytologi og historie.',
        'format' => 'simple',
      ],
      'field_person_additional_info' => [
        'value' => 'Født og opvokset i Middelfart, nu bosiddende i Horsens. Bestyrelsesmedlem i Dansk Forfatterforening. Afholder skriveworkshops for unge og voksne. Aktiv i lokale litteraturklubber og kulturforeninger. I fritiden samler jeg på førsteoplag af H.C. Andersens eventyr og arrangerer litteraturvandringer i hovedstaden.',
        'format' => 'simple',
      ],
    ]);

    $this->createPerson([
      'mail' => 'person006@example.com',
    ], [
      'field_person_navn' => 'Navn Navnesen',
      'field_person_kommune' => $this->getReference('kommune:Herning'),
      'field_person_funktion_erfaring' => [
            [
              // Important: We must use “…_TARGET_ID” to make this work.
              FunktionErfaringItem::PROPERTY_FUNKTION_TARGET_ID => $this->getReference('funktion:Runner')->id(),
              FunktionErfaringItem::PROPERTY_ERFARING_TARGET_ID => $this->getReference('erfaring:Nogen erfaring fra professionelle produktioner (5-10 produktioner)')->id(),
            ],
            [
              FunktionErfaringItem::PROPERTY_FUNKTION_TARGET_ID => $this->getReference('funktion:Animator')->id(),
              FunktionErfaringItem::PROPERTY_ERFARING_TARGET_ID => $this->getReference('erfaring:Lidt erfaring fra professionelle produktioner (1-4 produktioner)')->id(),
            ],
      ],
      'field_person_title' => [
        'value' => 'Kulturformidler | Forfatter | Underviser ved Horsens Professionshøjskole',
        'format' => 'simple',
      ],
      'field_person_education_interest' => [
        'value' => 'Kandidat i Nordiske Studier fra Horsens Universitet med speciale i moderne dansk litteratur. Efteruddannelse i kreativ skrivning fra Forfatterskolen. Forsker i folkeeventyr og mundtlige fortælletraditioner i Skandinavien.',
        'format' => 'simple',
      ],
      'field_person_about' => [
        'value' => 'Jeg har arbejdet med litteratur og kulturformidling i 20 år, først som bibliotekar og senere som forfatter og underviser. Min passion er at gøre dansk kulturarv tilgængelig for nye generationer gennem moderne fortælleformer. Jeg har udgivet tre romaner og en samling noveller, der alle er inspireret af nordisk mytologi og historie.',
        'format' => 'simple',
      ],
      'field_person_additional_info' => [
        'value' => 'Født og opvokset i Middelfart, nu bosiddende i Horsens. Bestyrelsesmedlem i Dansk Forfatterforening. Afholder skriveworkshops for unge og voksne. Aktiv i lokale litteraturklubber og kulturforeninger. I fritiden samler jeg på førsteoplag af H.C. Andersens eventyr og arrangerer litteraturvandringer i hovedstaden.',
        'format' => 'simple',
      ],
    ]);

    $this->createPerson([
      'mail' => 'person1@example.com',
      'status' => 0,
    ], [
      'field_person_kommune' => $this->getReference('kommune:Aarhus'),
    ]);

    $this->createPersonsWithAllFunktionerAndExperiences();

    // Create the first user.
    $this->createPerson([
      'mail' => 'first@example.com',
      'created' => new DrupalDateTime('1980-01-01')->getTimestamp(),
      'field_person_navn' => 'The first person',
      'status' => 1,
    ], [
      'field_person_kommune' => $this->getReference('kommune:Aarhus'),
      'field_person_phone' => '00000000',
    ]);

    // Create the latest user.
    $this->createPerson([
      'mail' => 'latest@example.com',
      'field_person_navn' => 'The latest person',
      'created' => new DrupalDateTime('2030-01-01')->getTimestamp(),
      'status' => 1,
    ], [
      'field_person_kommune' => $this->getReference('kommune:Aarhus'),
      'field_person_phone' => '00000000',
    ]);
  }

  /**
   * Create person with user and profiles values.
   */
  protected function createPerson(array $userValues, array $profileValues): array {
    $user = $this->createUser($userValues);
    $user->save();
    $profile = $this->createProfile($user, $profileValues);
    $profile->save();

    return [$user, $profile];
  }

  /**
   * {@inheritdoc}
   */
  protected function createUser(array $values = []): UserInterface {
    return parent::createUser($values)
      ->addRole(self::ROLE_PERSON_ID);
  }

  /**
   * Create person profile for a person.
   */
  private function createProfile(UserInterface $user, array $values) {
    if (empty($user->id())) {
      throw new \LogicException('User must have an ID.');
    }
    return $this->profileStorage
      ->create([
        'type' => Helper::PROFILE_PERSON,
        'uid' => $user->id(),
      ] + $values
      )
      ->setDefault(TRUE);
  }

  /**
   * Create persons with all funktioner and experiences.
   */
  private function createPersonsWithAllFunktionerAndExperiences() {
    /** @var \Drupal\taxonomy\TermInterface[] $funktions */
    $funktions = $this->taxonomyTermStorage->loadTree(FunktionTermFixture::$vocabularyId, load_entities: TRUE);
    /** @var \Drupal\taxonomy\TermInterface[] $erfarings */
    $erfarings = $this->taxonomyTermStorage->loadTree(ErfaringTermFixture::$vocabularyId, load_entities: TRUE);
    $counter = 0;
    foreach ($funktions as $funktion) {
      foreach ($erfarings as $erfaring) {
        $this->createPerson([
          'mail' => sprintf('person-f%d-e%d@example.com', $funktion->id(), $erfaring->id()),
          'status' => 1,
        ], [
          'field_person_navn' => $this->faker->name(),
          'field_person_kommune' => $this->getReference('kommune:Aarhus'),
          'field_person_funktion_erfaring' => [
            [
              FunktionErfaringItem::PROPERTY_FUNKTION_TARGET_ID => $funktion->id(),
              FunktionErfaringItem::PROPERTY_ERFARING_TARGET_ID => $erfaring->id(),
            ],
          ],
          'field_person_image' => [
            $this->getReference(ImageFileFixture::getImageReferenceName($counter)),
          ],
        ]);

        $counter++;
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  #[\Override]
  public function getDependencies() {
    return [
      ImageFileFixture::class,
      KommuneTermFixture::class,
      FunktionTermFixture::class,
    ];
  }

}
