<?php

declare(strict_types=1);

namespace Drupal\filmfolk\Theme;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\Core\Theme\ThemeNegotiatorInterface;

/**
 * Theme negotiator.
 */
final class FilmfolkNegotiator implements ThemeNegotiatorInterface {

  /**
   * Constructs the negotiator object.
   */
  public function __construct(
    private readonly AccountProxyInterface $currentUser,
    private readonly ConfigFactoryInterface $configFactory,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function applies(RouteMatchInterface $route_match): bool {
    return $route_match->getRouteName() === 'profile.user_page.single'
      && $this->currentUser->hasPermission('view the administration theme');
  }

  /**
   * {@inheritdoc}
   */
  public function determineActiveTheme(RouteMatchInterface $route_match): ?string {
    $adminTheme = $this->configFactory->get('system.theme')->get('admin');

    // Return null to let others decide if no admin theme has been set
    // explicitly.
    return $adminTheme ?: NULL;
  }

}
