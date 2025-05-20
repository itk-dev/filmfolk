<?php

declare(strict_types=1);

namespace Drupal\filmfolk\EventSubscriber;

use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\core_event_dispatcher\Event\Theme\ThemeSuggestionsAlterEvent;
use Drupal\core_event_dispatcher\ThemeHookEvents;
use Drupal\filmfolk\Helper;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Theme event subscriber.
 */
final class ThemeEventSubscriber implements EventSubscriberInterface {

  use StringTranslationTrait;

  public function __construct(
    private readonly Helper $helper,
  ) {
  }

  /**
   * {@inheritdoc}
   */
  #[\Override]
  public static function getSubscribedEvents(): array {
    return [
      ThemeHookEvents::THEME_SUGGESTIONS_ALTER => 'themeSuggestionsAlter',
    ];
  }

  /**
   * Alter theme suggestions.
   */
  public function themeSuggestionsAlter(ThemeSuggestionsAlterEvent $event): void {
    $variables = $event->getVariables();
    $hook = $event->getHook();
    if ('details' === $hook) {
      if ($key = $variables['element']['#parents'][0] ?? NULL) {
        $suggestions = &$event->getSuggestions();
        $suggestions[] = $hook . '__' . $key;
      }
    }
  }

}
