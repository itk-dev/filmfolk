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
    'Ingen erfaring fra professionelle produktioner',
    'Lidt erfaring fra professionelle produktioner (1-4 produktioner)',
    'Nogen erfaring fra professionelle produktioner (5-10 produktioner)',
    'Meget erfaring fra professionelle produktioner (10+ produktioner)',
  ];

}
