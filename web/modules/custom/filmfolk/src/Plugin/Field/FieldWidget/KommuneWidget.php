<?php

declare(strict_types=1);

namespace Drupal\filmfolk\Plugin\Field\FieldWidget;

use Drupal\Core\Field\Attribute\FieldWidget;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\Plugin\Field\FieldWidget\OptionsSelectWidget;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\taxonomy\Entity\Term;

/**
 * Defines the 'filmfolk_kommune' field widget.
 */
#[FieldWidget(
  id: 'filmfolk_kommune',
  label: new TranslatableMarkup('Kommune'),
  field_types: ['entity_reference'],
)]
final class KommuneWidget extends OptionsSelectWidget {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state): array {
    $element = parent::formElement($items, $delta, $element, $form, $form_state);

    // @todo Check that terms are from the kommune vocabulary.
    $options = &$element['#options'];
    $ids = array_keys($options);
    $terms = Term::loadMultiple($ids);
    foreach ($options as $id => &$option) {
      if ($terms[$id]?->get('field_medlem_af_dvf')->value) {
        $option .= $this->t(' (member of DSV)');
      }
    }

    return $element;
  }

}
