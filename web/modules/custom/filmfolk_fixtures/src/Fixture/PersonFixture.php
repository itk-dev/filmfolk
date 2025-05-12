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

    // Person 1: Mette Larsen - kulturformidler.
    $user1 = $this->createUser([
      'mail' => 'mette.larsen@example.com',
      'field_navn' => 'Mette Larsen',
      'field_kommune' => $this->getReference('kommune:Horsens'),
      'field_funktion' => [
        $this->getReference('funktion:PR og markedsføring'),
        $this->getReference('funktion:Manuskriptforfatter'),
      ],
      'field_funktion_erfaring' => [
        [
          FunktionErfaringItem::PROPERTY_FUNKTION_TARGET_ID => $this->getReference('funktion:PR og markedsføring')->id(),
          FunktionErfaringItem::PROPERTY_ERFARING_TARGET_ID => $this->getReference('erfaring:5 produktioner')->id(),
        ],
        [
          FunktionErfaringItem::PROPERTY_FUNKTION_TARGET_ID => $this->getReference('funktion:Manuskriptforfatter')->id(),
          FunktionErfaringItem::PROPERTY_ERFARING_TARGET_ID => $this->getReference('erfaring:3 produktioner')->id(),
        ],
      ],
      'field_profile_picture' => [
        'target_id' => $default_profile_picture_media->id(),
      ],
      'field_profiletitle' => [
        'value' => 'Kulturformidler | Forfatter | Underviser ved Horsens Professionshøjskole',
        'format' => 'simple',
      ],
      'field_profile_education_interest' => [
        'value' => 'Kandidat i Nordiske Studier fra Horsens Universitet med speciale i moderne dansk litteratur. Efteruddannelse i kreativ skrivning fra Forfatterskolen. Forsker i folkeeventyr og mundtlige fortælletraditioner i Skandinavien.',
        'format' => 'simple',
      ],
      'field_profile_about' => [
        'value' => 'Jeg har arbejdet med litteratur og kulturformidling i 20 år, først som bibliotekar og senere som forfatter og underviser. Min passion er at gøre dansk kulturarv tilgængelig for nye generationer gennem moderne fortælleformer. Jeg har udgivet tre romaner og en samling noveller, der alle er inspireret af nordisk mytologi og historie.',
        'format' => 'simple',
      ],
      'field_profile_additional_info' => [
        'value' => 'Født og opvokset i Middelfart, nu bosiddende i Horsens. Bestyrelsesmedlem i Dansk Forfatterforening. Afholder skriveworkshops for unge og voksne. Aktiv i lokale litteraturklubber og kulturforeninger. I fritiden samler jeg på førsteoplag af H.C. Andersens eventyr og arrangerer litteraturvandringer i hovedstaden.',
        'format' => 'simple',
      ],
      'field_consent_site_terms' => 1,
    ])
      ->activate();
    $user1->save();

    // Person 2: Anders Jensen - fotograf og belyser.
    $user2 = $this->createUser([
      'mail' => 'anders.jensen@example.com',
      'field_navn' => 'Anders Jensen',
      'field_kommune' => $this->getReference('kommune:Aarhus'),
    ]);
    $user->save();

    $this->createPersonsWithAllFunktionerAndExperiences();
      'field_funktion' => [
        $this->getReference('funktion:Fotograf / film'),
        $this->getReference('funktion:Belyser'),
        $this->getReference('funktion:Digital Image Technician'),
      ],
      'field_funktion_erfaring' => [
        [
          FunktionErfaringItem::PROPERTY_FUNKTION_TARGET_ID => $this->getReference('funktion:Fotograf / film')->id(),
          FunktionErfaringItem::PROPERTY_ERFARING_TARGET_ID => $this->getReference('erfaring:10+ produktioner')->id(),
        ],
        [
          FunktionErfaringItem::PROPERTY_FUNKTION_TARGET_ID => $this->getReference('funktion:Belyser')->id(),
          FunktionErfaringItem::PROPERTY_ERFARING_TARGET_ID => $this->getReference('erfaring:8 produktioner')->id(),
        ],
        [
          FunktionErfaringItem::PROPERTY_FUNKTION_TARGET_ID => $this->getReference('funktion:Digital Image Technician')->id(),
          FunktionErfaringItem::PROPERTY_ERFARING_TARGET_ID => $this->getReference('erfaring:4 produktioner')->id(),
        ],
      ],
      'field_profile_picture' => [
        'target_id' => $default_profile_picture_media->id(),
      ],
      'field_profiletitle' => [
        'value' => 'Fotograf | Belyser | Digital Image Technician',
        'format' => 'simple',
      ],
      'field_profile_education_interest' => [
        'value' => 'Uddannet fra Den Danske Filmskole med speciale i filmfotografi. Videreuddannelse i digital billedteknologi og avanceret belysning. Særlig interesse for visuelle fortællinger med naturligt lys og for tekniske innovationer inden for filmkameraer.',
        'format' => 'simple',
      ],
      'field_profile_about' => [
        'value' => 'Med over 15 års erfaring i filmbranchen har jeg arbejdet på spillefilm, dokumentarer og reklameproduktioner. Jeg kombinerer teknisk ekspertise med et kunstnerisk blik og samarbejder tæt med instruktører for at realisere deres visuelle vision. Min tilgang er præget af grundighed og kreativitet i alle faser af produktionen.',
        'format' => 'simple',
      ],
      'field_profile_additional_info' => [
        'value' => 'Bosiddende i Aarhus. Medlem af Danske Filmfotografer og aktiv i det aarhusianske filmmiljø. Underviser lejlighedsvis på filmværksteder i Jylland. Rejser gerne for spændende projekter i ind- og udland. Vinder af Robert-prisen for bedste fotografi i 2019.',
        'format' => 'simple',
      ],
      'field_consent_site_terms' => 1,
    ])
      ->activate();
    $user2->save();

    // Person 3: Sofie Pedersen - skuespiller.
    $user3 = $this->createUser([
      'mail' => 'sofie.pedersen@example.com',
      'field_navn' => 'Sofie Pedersen',
      'field_kommune' => $this->getReference('kommune:Middelfart'),
      'field_funktion' => [
        $this->getReference('funktion:Skuespiller'),
        $this->getReference('funktion:Casting / caster'),
      ],
      'field_funktion_erfaring' => [
        [
          FunktionErfaringItem::PROPERTY_FUNKTION_TARGET_ID => $this->getReference('funktion:Skuespiller')->id(),
          FunktionErfaringItem::PROPERTY_ERFARING_TARGET_ID => $this->getReference('erfaring:10+ produktioner')->id(),
        ],
        [
          FunktionErfaringItem::PROPERTY_FUNKTION_TARGET_ID => $this->getReference('funktion:Casting / caster')->id(),
          FunktionErfaringItem::PROPERTY_ERFARING_TARGET_ID => $this->getReference('erfaring:2 produktioner')->id(),
        ],
      ],
      'field_profile_picture' => [
        'target_id' => $default_profile_picture_media->id(),
      ],
      'field_profiletitle' => [
        'value' => 'Skuespiller | Castingassistent | Performer',
        'format' => 'simple',
      ],
      'field_profile_education_interest' => [
        'value' => 'Uddannet fra Statens Teaterskole. Efteruddannelse i kamera-skuespil og metode-acting fra workshop hos Panorama Academy. Særlig interesse for karakterroller med psykologisk dybde og for moderne fortolkninger af klassiske tekster.',
        'format' => 'simple',
      ],
      'field_profile_about' => [
        'value' => 'Jeg har medvirket i en bred vifte af produktioner fra tv-serier og spillefilm til teater og reklamer gennem de sidste 12 år. Min styrke ligger i evnen til at formidle komplekse følelser med subtile virkemidler og i min alsidighed som performer. Jeg arbejder intuitivt men disciplineret og er kendt for min professionalisme på settet.',
        'format' => 'simple',
      ],
      'field_profile_additional_info' => [
        'value' => 'Bosat i Middelfart, men arbejder over hele landet. Flydende i dansk, engelsk og svensk. Har grundlæggende færdigheder i sang, dans og klaverspil. Driver sideløbende med skuespillet et mindre castingbureau for børn og unge. Vinder af Reumert-talentprisen og Bodil-nomineret for bedste kvindelige birolle.',
        'format' => 'simple',
      ],
      'field_consent_site_terms' => 1,
    ])
      ->activate();
    $user3->save();

    // Person 4: Lars Nielsen - lydtekniker og komponist.
    $user4 = $this->createUser([
      'mail' => 'lars.nielsen@example.com',
      'field_navn' => 'Lars Nielsen',
      'field_kommune' => $this->getReference('kommune:Aalborg'),
      'field_funktion' => [
        $this->getReference('funktion:Tonemester'),
        $this->getReference('funktion:Komponist'),
        $this->getReference('funktion:Postproduktion / lyd og musik'),
      ],
      'field_funktion_erfaring' => [
        [
          FunktionErfaringItem::PROPERTY_FUNKTION_TARGET_ID => $this->getReference('funktion:Tonemester')->id(),
          FunktionErfaringItem::PROPERTY_ERFARING_TARGET_ID => $this->getReference('erfaring:10+ produktioner')->id(),
        ],
        [
          FunktionErfaringItem::PROPERTY_FUNKTION_TARGET_ID => $this->getReference('funktion:Komponist')->id(),
          FunktionErfaringItem::PROPERTY_ERFARING_TARGET_ID => $this->getReference('erfaring:6 produktioner')->id(),
        ],
        [
          FunktionErfaringItem::PROPERTY_FUNKTION_TARGET_ID => $this->getReference('funktion:Postproduktion / lyd og musik')->id(),
          FunktionErfaringItem::PROPERTY_ERFARING_TARGET_ID => $this->getReference('erfaring:9 produktioner')->id(),
        ],
      ],
      'field_profile_picture' => [
        'target_id' => $default_profile_picture_media->id(),
      ],
      'field_profiletitle' => [
        'value' => 'Tonemester | Komponist | Lyddesigner',
        'format' => 'simple',
      ],
      'field_profile_education_interest' => [
        'value' => 'Uddannet fra Rytmisk Musikkonservatorium med speciale i lyddesign og filmmusik. Supplerende uddannelse i akustik og digital lydbehandling. Særlig interesse for felt-optagelser, eksperimentel lyddesign og integration af traditionelle instrumenter i elektroniske kompositioner.',
        'format' => 'simple',
      ],
      'field_profile_about' => [
        'value' => 'Gennem 18 år i branchen har jeg arbejdet med alle aspekter af lyd til film og medier - fra optagelse på location til mix og mastering i studiet. Som komponist skaber jeg skræddersyede lyduniverser der understøtter fortællingen. Jeg er teknisk stærk men altid med det kreative i fokus, og jeg prioriterer tæt samarbejde med instruktører og klippere.',
        'format' => 'simple',
      ],
      'field_profile_additional_info' => [
        'value' => 'Har base i Aalborg hvor jeg driver mit eget lydstudie. Rejser gerne for optagelser og samarbejder. Underviser deltid ved Aalborg Universitet i lyddesign. Har et omfattende bibliotek af specialoptagelser fra hele verden. Robert-vinder for bedste lyddesign 2018 og 2021. Spiller kontrabas, guitar og diverse elektroniske instrumenter.',
        'format' => 'simple',
      ],
      'field_consent_site_terms' => 1,
    ])
      ->activate();
    $user4->save();

    // Person 5: Nikolaj Hansen - location manager.
    $user5 = $this->createUser([
      'mail' => 'nikolaj.hansen@example.com',
      'field_navn' => 'Nikolaj Hansen',
      'field_kommune' => $this->getReference('kommune:Esbjerg'),
      'field_funktion' => [
        $this->getReference('funktion:Location manager'),
        $this->getReference('funktion:Locationscout'),
        $this->getReference('funktion:Produktionsassistent'),
      ],
      'field_funktion_erfaring' => [
        [
          FunktionErfaringItem::PROPERTY_FUNKTION_TARGET_ID => $this->getReference('funktion:Location manager')->id(),
          FunktionErfaringItem::PROPERTY_ERFARING_TARGET_ID => $this->getReference('erfaring:7 produktioner')->id(),
        ],
        [
          FunktionErfaringItem::PROPERTY_FUNKTION_TARGET_ID => $this->getReference('funktion:Locationscout')->id(),
          FunktionErfaringItem::PROPERTY_ERFARING_TARGET_ID => $this->getReference('erfaring:10+ produktioner')->id(),
        ],
        [
          FunktionErfaringItem::PROPERTY_FUNKTION_TARGET_ID => $this->getReference('funktion:Produktionsassistent')->id(),
          FunktionErfaringItem::PROPERTY_ERFARING_TARGET_ID => $this->getReference('erfaring:3 produktioner')->id(),
        ],
      ],
      'field_profile_picture' => [
        'target_id' => $default_profile_picture_media->id(),
      ],
      'field_profiletitle' => [
        'value' => 'Location Manager | Scout | Produktionskoordinator',
        'format' => 'simple',
      ],
      'field_profile_education_interest' => [
        'value' => 'BA i Medievidenskab fra Syddansk Universitet. Videreuddannelse i projektledelse og kulturforvaltning. Særlig interesse for unikke locations i Vestjylland og for samarbejde mellem filmbranchen og lokalmiljøer. Stor viden om logistik og praktiske udfordringer ved location-optagelser.',
        'format' => 'simple',
      ],
      'field_profile_about' => [
        'value' => 'Med baggrund i både film og eventproduktion har jeg specialiseret mig i at finde og administrere locations for film- og tv-produktioner. Jeg har et omfattende netværk af kontakter i hele landet og erfaring med alle former for locations fra historiske bygninger til industriområder og naturscenerier. Min styrke ligger i at løse praktiske problemer på stedet og skabe gode relationer til lokale interessenter.',
        'format' => 'simple',
      ],
      'field_profile_additional_info' => [
        'value' => 'Bosiddende i Esbjerg med familie, men dækker hele Danmark med særligt kendskab til Vestjylland. Ejer af bil med trailer og grundlæggende teknisk forståelse. Tidligere bestyrelsesmedlem i Vestjysk Filmforum. Erfaring med tilladelser og myndighedskontakt. Har et omfattende billedarkiv af potentielle locations kategoriseret efter type og region.',
        'format' => 'simple',
      ],
      'field_consent_site_terms' => 1,
    ])
      ->activate();
    $user5->save();
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
