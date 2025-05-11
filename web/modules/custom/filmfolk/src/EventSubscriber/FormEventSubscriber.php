<?php

declare(strict_types=1);

namespace Drupal\filmfolk\EventSubscriber;

use Drupal\Component\Render\MarkupInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\core_event_dispatcher\Event\Form\FormAlterEvent;
use Drupal\core_event_dispatcher\FormHookEvents;
use Drupal\filmfolk\Helper;
use Drupal\filmfolk\Plugin\Field\FieldType\FunktionErfaringItem;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Form event subscriber.
 */
final class FormEventSubscriber implements EventSubscriberInterface {

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
      FormHookEvents::FORM_ALTER => 'formAlter',
    ];
  }

  /**
   * Form alter event handler.
   */
  public function formAlter(FormAlterEvent $event): void {
    switch ($event->getFormId()) {
      case 'views_exposed_form':
        $this->viewsExposedFormAlter($event);
        break;
    }
  }

  /**
   * Change funktion-erfaring filters to dropdowns.
   */
  private function viewsExposedFormAlter(FormAlterEvent $event): void {
    $form = &$event->getForm();
    if (isset($form[FunktionErfaringItem::PROPERTY_FUNKTION])) {
      // Convert a textfield element to a select element.
      $convertToSelect = static function (array &$element, array $options) {
        unset($element['#size']);
        $element['#type'] = 'select';
        $element['#options'] = $options;
      };

      $element = &$form[FunktionErfaringItem::PROPERTY_FUNKTION];
      $convertToSelect($element,
        $this->getTermOptions(Helper::TAXONOMY_FUNKTION, $this->t('All functions'))
      );

      if (isset($form[FunktionErfaringItem::PROPERTY_ERFARING])) {
        $element = &$form[FunktionErfaringItem::PROPERTY_ERFARING];
        $convertToSelect($element,
          $this->getTermOptions(Helper::TAXONOMY_ERFARING, $this->t('All experiences'))
        );
        $element['#states'] = [
          'enabled' => [
            ':input[name="' . FunktionErfaringItem::PROPERTY_FUNKTION . '"]' => ['empty' => FALSE],
          ],
        ];
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
