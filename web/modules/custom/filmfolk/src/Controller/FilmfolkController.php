<?php

declare(strict_types=1);

namespace Drupal\filmfolk\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for Filmfolk routes.
 */
final class FilmfolkController extends ControllerBase {

  /**
   * Builds the response.
   */
  public function __invoke(): array {

    $build['content'] = [
      '#type' => 'item',
      '#markup' => $this->t('It works!'),
    ];

    return $build;
  }

}
