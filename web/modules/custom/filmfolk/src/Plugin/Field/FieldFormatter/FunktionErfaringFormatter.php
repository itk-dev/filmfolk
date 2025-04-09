<?php

declare(strict_types=1);

namespace Drupal\filmfolk\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\Attribute\FieldFormatter;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\filmfolk\Plugin\Field\FieldType\FunktionErfaringItem;

/**
 * Plugin implementation of the 'funktion_erfaring' formatter.
 */
#[FieldFormatter(
  id: 'filmfolk_funktion_erfaring',
  label: new TranslatableMarkup('funktion_erfaring'),
  field_types: ['filmfolk_funktion_erfaring'],
)]
final class FunktionErfaringFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode): array {
    $element = [];
    foreach ($items as $delta => $item) {
      $element[$delta] = [
        '#markup' => sprintf(
          '%s/%s',
          $item->get(FunktionErfaringItem::PROPERTY_FUNKTION)->getString(),
          $item->get(FunktionErfaringItem::PROPERTY_ERFARING)->getString()
        ),
      ];
    }
    return $element;
  }

}
