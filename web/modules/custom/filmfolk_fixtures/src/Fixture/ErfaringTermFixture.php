<?php

namespace Drupal\filmfolk_fixtures\Fixture;

/**
 * Erfaring term fixture.
 */
class ErfaringTermFixture extends AbstractTaxonomyTermFixture {
  /**
   * {@inheritdoc}
   */
  public static string $vocabularyId = 'erfaring';

  /**
   * {@inheritdoc}
   */
  protected static array $terms = [
    'Ingen erfaring',
    'Lidt erfaring (1-4 produktioner)',
    'Nogen erfaring (5-10 produktioner)',
    'Meget erfaring (10+ produktioner)',
  ];

}
