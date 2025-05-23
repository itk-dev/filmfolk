<?php

namespace Drupal\filmfolk_fixtures\Fixture;

use Drupal\taxonomy\Entity\Term;

/**
 * Kommune term fixture.
 */
class KommuneTermFixture extends AbstractTaxonomyTermFixture {
  /**
   * {@inheritdoc}
   */
  protected static string $vocabularyId = 'kommune';

  /**
   * {@inheritdoc}
   */
  protected static array $terms = [
    'Aabenraa',
    'Aalborg',
    'Aarhus',
    'Billund',
    'Brønderslev',
    'Esbjerg',
    'Fanø',
    'Favrskov',
    'Fredericia',
    'Frederikshavn',
    'Haderslev',
    'Hedensted',
    'Herning',
    'Hjørring',
    'Holstebro',
    'Horsens',
    'Ikast-Brande',
    'Jammerbugt',
    'Kolding',
    'Lemvig',
    'Læsø',
    'Mariagerfjord',
    'Middelfart',
    'Morsø',
    'Norddjurs',
    'Odder',
    'Randers',
    'Rebild',
    'Ringkøbing-Skjern',
    'Samsø',
    'Silkeborg',
    'Skanderborg',
    'Skive',
    'Struer',
    'Syddjurs',
    'Sønderborg',
    'Thisted',
    'Tønder',
    'Varde',
    'Vejen',
    'Vejle',
    'Vesthimmerlands',
    'Viborg',
  ];

  /**
   * DVF members.
   */
  private array $dvfMembers = [
    'Aarhus',
    'Fredericia',
    'Frederikshavn',
    'Hjørring',
    'Holstebro',
    'Kolding',
    'Odder',
    'Randers',
    'Ringkøbing-Skjern',
    'Silkeborg',
    'Syddjurs',
    'Tønder',
    'Viborg',
  ];

  /**
   * {@inheritdoc}
   */
  #[\Override]
  protected function createTerm(string $name, int $weight, ?Term $parent = NULL) {
    /** @var \Drupal\taxonomy\Entity\TermInterface $term */
    $term = parent::createTerm($name, $weight, $parent);

    if (in_array($term->getName(), $this->dvfMembers)) {
      $term->set('field_medlem_af_dvf', TRUE);
      $term->save();
    }

    return $term;
  }

}
