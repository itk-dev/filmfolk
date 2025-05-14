<?php

declare(strict_types=1);

namespace Drupal\filmfolk;

/**
 * Helper for filmfolk.
 */
class Helper {
  const string TAXONOMY_FUNKTION = 'funktion';
  const string TAXONOMY_ERFARING = 'erfaring';

  const string PROFILE_PERSON = 'person';

  /**
   * Load terms from a vocabulary.
   *
   * @param string $vocabulary
   *   The vocabulary.
   *
   * @return array<int, Term>
   *   The terms indexed by ID.
   *
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
  public function loadTerms(string $vocabulary): array {
    $terms = \Drupal::entityTypeManager()->getStorage('taxonomy_term')
      ->loadTree($vocabulary, load_entities: TRUE);

    // Index by term ID.
    $result = [];
    foreach ($terms as $term) {
      $result[(int) $term->id()] = $term;
    }

    return $result;
  }

}
