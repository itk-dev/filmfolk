<?php

declare(strict_types=1);

namespace Drupal\filmfolk\EventSubscriber;

use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\core_event_dispatcher\EntityHookEvents;
use Drupal\core_event_dispatcher\Event\Entity\EntityTypeAlterEvent;
use Drupal\filmfolk\Entity\Term;
use Drupal\filmfolk\Helper;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Entity event subscriber.
 */
final class EntityEventSubscriber implements EventSubscriberInterface {

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
      EntityHookEvents::ENTITY_TYPE_ALTER => 'entityTypeAlter',
    ];
  }

  /**
   * Alter entity type.
   */
  public function entityTypeAlter(EntityTypeAlterEvent $event): void {
    $types = $event->getEntityTypes();
    if (isset($types['taxonomy_term'])) {
      $types['taxonomy_term']->setClass(Term::class);
    }
  }

}
