<?php

declare(strict_types=1);

namespace Drupal\filmfolk\Plugin\Field\FieldType;

use Drupal\Core\Field\Attribute\FieldType;
use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Defines the 'filmfolk_funktion_erfaring' field type.
 */
#[FieldType(
  id: 'filmfolk_funktion_erfaring',
  label: new TranslatableMarkup('funktion_erfaring'),
  description: new TranslatableMarkup('Some description'),
  default_widget: 'filmfolk_funktion_erfaring',
  default_formatter: 'filmfolk_funktion_erfaring',
)]
final class FunktionErfaringItem extends FieldItemBase {
  const PROPERTY_FUNKTION = 'funktion_target_id';
  const PROPERTY_ERFARING = 'erfaring_target_id';

  /**
   * {@inheritdoc}
   */
  public function isEmpty(): bool {
    return match ($this->get(self::PROPERTY_FUNKTION)->getValue()) {
      NULL, '' => TRUE,
        default => FALSE,
    }
    || match ($this->get(self::PROPERTY_ERFARING)->getValue()) {
      NULL, '' => TRUE,
        default => FALSE,
    };
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition): array {
    // https://drupal.stackexchange.com/a/214417
    //
    //    $properties[self::PROPERTY_FUNKTION] = DataReferenceDefinition::create('entity')
    //      ->setTargetDefinition(EntityDataDefinition::create('taxonomy_term'))
    //      ->setLabel(t('Funktion'))
    //      ->setSettings([
    //        'target_type' => 'taxonomy_term',
    //        'handler' => 'default:taxonomy_term',
    //        'handler_settings', [
    //          'target_bundles' => [
    //            'funktion' => 'funktion'
    //          ]
    //        ]
    //      ])
    //      ->setRequired(TRUE);
    //
    //    $properties[self::PROPERTY_ERFARING] = DataReferenceDefinition::create('entity')
    //      ->setTargetDefinition(EntityDataDefinition::create('taxonomy_term'))
    //      ->setLabel(t('Erfaring'))
    //      ->setSettings([
    //        'target_type' => 'taxonomy_term',
    //        'handler' => 'default:taxonomy_term',
    //        'handler_settings', [
    //          'target_bundles' => [
    //            'erfaring' => 'erfaring'
    //          ]
    //        ]
    //      ])
    //      ->setRequired(TRUE);
    // Am I supposed to be able to make the reference stuff above work?!
    $properties[self::PROPERTY_FUNKTION] = DataDefinition::create('integer')
      ->setLabel(t('Funktion'))
      ->setRequired(TRUE);

    $properties[self::PROPERTY_ERFARING] = DataDefinition::create('integer')
      ->setLabel(t('Erfaring'))
      ->setRequired(TRUE);

    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition): array {
    $columns = [
      self::PROPERTY_FUNKTION => [
        'type' => 'int',
        'unsigned' => TRUE,
        'not null' => TRUE,
      ],
    ];
    $columns[self::PROPERTY_ERFARING] = $columns[self::PROPERTY_FUNKTION];

    $schema = [
      'columns' => $columns,
      // @todo Add indexes here if necessary.
    ];

    return $schema;
  }

}
