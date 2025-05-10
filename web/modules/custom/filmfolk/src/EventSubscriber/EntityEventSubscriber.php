<?php

declare(strict_types=1);

namespace Drupal\filmfolk\EventSubscriber;

use Drupal\Component\Render\MarkupInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\core_event_dispatcher\EntityHookEvents;
use Drupal\core_event_dispatcher\Event\Entity\EntityTypeAlterEvent;
use Drupal\core_event_dispatcher\Event\Form\FormAlterEvent;
use Drupal\core_event_dispatcher\FormHookEvents;
use Drupal\filmfolk\Entity\Term;
use Drupal\filmfolk\Helper;
use Drupal\taxonomy\TermStorageInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Entity event subscriber.
 */
final class EntityEventSubscriber implements EventSubscriberInterface {

  use StringTranslationTrait;

  /**
   * The term storage.
   */
  private TermStorageInterface $termStorage;

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
      FormHookEvents::FORM_ALTER => 'formAlter',
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

  /**
   * Change funktion-erfaring filters to dropdowns.
   */
  public function formAlter(FormAlterEvent $event): void {
    if ('views_exposed_form' === $event->getFormId()) {
      $form = &$event->getForm();
      if (isset($form['funktion_target_id'])) {
        $options = $this->getTermOptions('funktion', $this->t('All functions'));
        unset($form['funktion_target_id']['#size']);
        $form['funktion_target_id']['#type'] = 'select';
        $form['funktion_target_id']['#options'] = $options;

        if (isset($form['erfaring_target_id'])) {
          $options = $this->getTermOptions('erfaring', $this->t('All experiences'));
          unset($form['erfaring_target_id']['#size']);
          $form['erfaring_target_id']['#type'] = 'select';
          $form['erfaring_target_id']['#options'] = $options;
          $form['erfaring_target_id']['#states'] = [
            'enabled' => [
              ':input[name="funktion_target_id"]' => ['empty' => FALSE],
            ],
          ];
        }
      }
    }
  }

  /**
   * Get term options.
   */
  private function getTermOptions(string $vocabulary, string|MarkupInterface|null $emptyOptionLabel = NULL): array {
    $terms = $this->helper->loadTerms($vocabulary);

    $options = [];
    if ($emptyOptionLabel) {
      $options[''] = $emptyOptionLabel;
    }
    foreach ($terms as $term) {
      $options[$term->id()] = $term->label();
    }

    return $options;
  }

}
