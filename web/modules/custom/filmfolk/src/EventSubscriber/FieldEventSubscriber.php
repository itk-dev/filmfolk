<?php

declare(strict_types=1);

namespace Drupal\filmfolk\EventSubscriber;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\field_event_dispatcher\Event\Field\WidgetSingleElementFormAlterEvent;
use Drupal\field_event_dispatcher\FieldHookEvents;
use Drupal\filmfolk\Helper;
use Drupal\preprocess_event_dispatcher\Event\FieldPreprocessEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Field event subscriber.
 */
final class FieldEventSubscriber implements EventSubscriberInterface {

  use StringTranslationTrait;

  public function __construct(
    private readonly Helper $helper,
    private readonly AccountInterface $account,
    private readonly RouteMatchInterface $routeMatch,
  ) {
  }

  /**
   * {@inheritdoc}
   */
  #[\Override]
  public static function getSubscribedEvents(): array {
    return [
      // We're awaiting https://www.drupal.org/project/drupal/issues/3323007
      FieldHookEvents::WIDGET_SINGLE_ELEMENT_FORM_ALTER => 'widgetSingleElementFormAlter',
      FieldPreprocessEvent::name() => 'preprocessField',
    ];
  }

  /**
   * Override link text on some fields.
   */
  public function preprocessField(FieldPreprocessEvent $event) {
    // Field name => link text.
    $fieldListTexts = [
      'field_person_facebook_link' => new TranslatableMarkup('Link to Facebook'),
      'field_person_imdb_link' => new TranslatableMarkup('Link to IMDb'),
      'field_person_linkedin_link' => new TranslatableMarkup('Link to LinkedIn'),
    ];

    $variables = $event->getVariables();
    $type = $variables->get('field_type');
    $name = $variables->get('field_name');
    if ('link' === $type && isset($fieldListTexts[$name])) {
      $items = &$variables->getByReference('items');
      $items[0]['content']['#title'] = $fieldListTexts[$name];
    }
  }

  /**
   * Widget single element form alter event handler.
   */
  public function widgetSingleElementFormAlter(WidgetSingleElementFormAlterEvent $event): void {
    $element = &$event->getElement();
    $element['#after_build'][] = [$this::class, 'widgetSingleElementFormAlterAfterBuild'];
  }

  /**
   * Lifted from https://www.drupal.org/project/allowed_formats.
   *
   * @see https://git.drupalcode.org/project/allowed_formats/-/blob/3.0.x/allowed_formats.module?ref_type=heads
   */
  public static function widgetSingleElementFormAlterAfterBuild(array $form_element, FormStateInterface $form_state) {
    if (isset($form_element['format'])) {
      unset($form_element['format']['help'], $form_element['format']['guidelines']);

      // If nothing is left in the wrapper, hide it as well.
      if (1 === count($form_element['#allowed_formats'] ?? [])) {
        unset($form_element['format']['#type']);
        unset($form_element['format']['#theme_wrappers']);
      }
    }

    return $form_element;
  }

}
