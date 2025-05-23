<?php

namespace Drupal\filmfolk_fixtures\Fixture;

use Drupal\content_fixtures\Fixture\AbstractFixture;
use Drupal\taxonomy\Entity\Term;

/**
 * Taxonomy terms fixture.
 */
abstract class AbstractTaxonomyTermFixture extends AbstractFixture {
  /**
   * The vocabulary id.
   *
   * @var string
   */
  protected static string $vocabularyId;

  /**
   * The terms.
   *
   * Each item must be a term name or term name => [child term names], e.g.
   *
   * [
   *   'test',
   *   'science' => [
   *     'math',
   *     'computer science',
   *   ],
   *   'books',
   * ]
   *
   * @var array
   */
  protected static array $terms;

  /**
   * Constructor.
   */
  public function __construct() {
    if (NULL === static::$vocabularyId) {
      throw new \RuntimeException(sprintf('Vocabulary id not defined in %s', static::class));
    }
    if (empty(static::$terms)) {
      throw new \RuntimeException(sprintf('No terms defined in %s', static::class));
    }
  }

  /**
   * {@inheritdoc}
   */
  #[\Override]
  public function load() {
    $this->createTerms(static::$terms);
  }

  /**
   * Create terms.
   *
   * @param array $items
   *   The items.
   * @param \Drupal\taxonomy\Entity\Term|null $parent
   *   The optional term parent.
   *
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  private function createTerms(array $items, ?Term $parent = NULL) {
    $weight = 0;
    foreach ($items as $name => $value) {
      if (is_array($value)) {
        $term = $this->createTerm($name, $weight, $parent);
        $this->createTerms($value, $term);
      }
      else {
        $this->createTerm($value ?: $name, $weight, $parent);
      }
      $weight++;
    }
  }

  /**
   * Create a term.
   *
   * @param string $name
   *   The term name.
   * @param int $weight
   *   The term weight.
   * @param \Drupal\taxonomy\Entity\Term|null $parent
   *   The optional term parent.
   *
   * @return \Drupal\taxonomy\Entity\Term
   *   The term.
   *
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  protected function createTerm(string $name, int $weight, ?Term $parent = NULL) {
    $term = Term::create([
      'vid' => static::$vocabularyId,
      'weight' => $weight,
      'name' => $name,
    ]);

    $referenceName = $name;
    if (NULL !== $parent) {
      $term->set('parent', $parent->id());
      $referenceName = $parent->getName() . ':' . $name;
    }

    $this->setReference(static::$vocabularyId . ':' . $referenceName, $term);
    $term->save();

    return $term;
  }

}
