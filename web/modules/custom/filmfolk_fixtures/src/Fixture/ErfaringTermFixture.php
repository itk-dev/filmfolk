<?php

namespace Drupal\filmfolk_fixtures\Fixture;

/**
 * Erfaring term fixture.
 */
class ErfaringTermFixture extends AbstractTaxonomyTermFixture {
  /**
   * {@inheritdoc}
   */
  protected static string $vocabularyId = 'erfaring';

  /**
   * {@inheritdoc}
   */
  protected static array $terms = [
    '0 produktioner',
    '1 produktion',
    '2 produktioner',
    '3 produktioner',
    '4 produktioner',
    '5 produktioner',
    '6 produktioner',
    '7 produktioner',
    '8 produktioner',
    '9 produktioner',
    '10+ produktioner',
  ];

}
