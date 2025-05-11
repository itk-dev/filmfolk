<?php

declare(strict_types=1);

namespace Drupal\filmfolk\Plugin\Field\FieldType;

use Drupal\Core\Entity\TypedData\EntityDataDefinition;
use Drupal\Core\Field\Attribute\FieldType;
use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\Core\TypedData\DataReferenceDefinition;
use Drupal\Core\TypedData\DataReferenceTargetDefinition;
use Drupal\filmfolk\Helper;
use Drupal\taxonomy\Entity\Term;

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
  const string PROPERTY_FUNKTION = Helper::TAXONOMY_FUNKTION;
  const string PROPERTY_ERFARING = Helper::TAXONOMY_ERFARING;

  const string PROPERTY_FUNKTION_TARGET_ID = self::PROPERTY_FUNKTION . '_target_id';
  const string PROPERTY_ERFARING_TARGET_ID = self::PROPERTY_ERFARING . '_target_id';

  /**
   * Get funktion.
   */
  public function getFunktion(): ?Term {
    return $this->get(self::PROPERTY_FUNKTION)->getValue() ?: NULL;
  }

  /**
   * Get erfaring.
   */
  public function getErfaring(): ?Term {
    return $this->get(self::PROPERTY_ERFARING)->getValue() ?: NULL;
  }

  /**
   * {@inheritdoc}
   */
  #[\Override]
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition): array {
    $targetType = \Drupal::entityTypeManager()->getDefinition('taxonomy_term');

    // The funktion target ID property.
    $properties[self::PROPERTY_FUNKTION_TARGET_ID] = DataReferenceTargetDefinition::create('integer')
      ->setLabel(new TranslatableMarkup('Funktion @label ID', ['@label' => $targetType->getLabel()]))
      ->setSetting('unsigned', TRUE)
      ->setRequired(TRUE);

    // The actual funktion property.
    $properties[self::PROPERTY_FUNKTION] = DataReferenceDefinition::create('entity')
      ->setDescription(new TranslatableMarkup('The referenced Funktion @label', ['@label' => $targetType->getLabel()]))
      ->setComputed(TRUE)
      ->setReadOnly(FALSE)
      ->setTargetDefinition(EntityDataDefinition::create($targetType->id()))
      ->addConstraint('EntityType', $targetType->id());

    // The erfaring target ID property.
    $properties[self::PROPERTY_ERFARING_TARGET_ID] = DataReferenceTargetDefinition::create('integer')
      ->setLabel(new TranslatableMarkup('Erfaring @label ID', ['@label' => $targetType->getLabel()]))
      ->setSetting('unsigned', TRUE)
      ->setRequired(TRUE);

    // The actual erfaring property.
    $properties[self::PROPERTY_ERFARING] = DataReferenceDefinition::create('entity')
      ->setDescription(new TranslatableMarkup('The referenced Erfaring @label', ['@label' => $targetType->getLabel()]))
      ->setComputed(TRUE)
      ->setReadOnly(FALSE)
      ->setTargetDefinition(EntityDataDefinition::create($targetType->id()))
      ->addConstraint('EntityType', $targetType->id());

    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  #[\Override]
  public static function schema(FieldStorageDefinitionInterface $field_definition): array {
    $columns = [
      self::PROPERTY_FUNKTION_TARGET_ID => [
        'type' => 'int',
        'unsigned' => TRUE,
      ],
    ];
    $columns[self::PROPERTY_ERFARING_TARGET_ID] = $columns[self::PROPERTY_FUNKTION_TARGET_ID];

    $schema = [
      'columns' => $columns,
      'indexes' => [
        self::PROPERTY_FUNKTION_TARGET_ID => [self::PROPERTY_FUNKTION_TARGET_ID],
        self::PROPERTY_ERFARING_TARGET_ID => [self::PROPERTY_ERFARING_TARGET_ID],
      ],
    ];

    return $schema;
  }

  /**
   * {@inheritdoc}
   *
   * Lifted from EntityReferenceItem.
   *
   * @see EntityReferenceItem::isEmpty()
   */
  #[\Override]
  public function isEmpty() {
    return !((($this->{self::PROPERTY_FUNKTION_TARGET_ID}
        || ($this->{self::PROPERTY_FUNKTION} && $this->{self::PROPERTY_FUNKTION} instanceof Term))
      && ($this->{self::PROPERTY_ERFARING_TARGET_ID}
        || ($this->{self::PROPERTY_ERFARING} && $this->{self::PROPERTY_ERFARING} instanceof Term))));
  }

  /**
   * {@inheritdoc}
   *
   *  Lifted from EntityReferenceItem.
   *
   * @see EntityReferenceItem::onChange()
 */
  #[\Override]
  public function onChange($property_name, $notify = TRUE) {
    // Make sure that the target ID and the target property stay in sync.
    if (self::PROPERTY_FUNKTION === $property_name) {
      $this->writePropertyValue(self::PROPERTY_FUNKTION_TARGET_ID, $this->get(self::PROPERTY_FUNKTION)->getTargetIdentifier());
    }
    elseif (self::PROPERTY_FUNKTION_TARGET_ID === $property_name) {
      $this->writePropertyValue(self::PROPERTY_FUNKTION, $this->{self::PROPERTY_FUNKTION_TARGET_ID});
    }
    if (self::PROPERTY_ERFARING === $property_name) {
      $this->writePropertyValue(self::PROPERTY_ERFARING_TARGET_ID, $this->get(self::PROPERTY_ERFARING)->getTargetIdentifier());
    }
    elseif (self::PROPERTY_ERFARING_TARGET_ID === $property_name) {
      $this->writePropertyValue(self::PROPERTY_ERFARING, $this->{self::PROPERTY_ERFARING_TARGET_ID});
    }
    parent::onChange($property_name, $notify);
  }

  /**
   * {@inheritdoc}
   */
  #[\Override]
  public function setValue($values, $notify = TRUE) {
    if (isset($values[self::PROPERTY_FUNKTION_TARGET_ID]) && !is_array($values[self::PROPERTY_FUNKTION_TARGET_ID])) {
      $this->set(self::PROPERTY_FUNKTION, $values[self::PROPERTY_FUNKTION_TARGET_ID], $notify);
      $this->set(self::PROPERTY_ERFARING, $values[self::PROPERTY_ERFARING_TARGET_ID], $notify);
    }
    else {
      parent::setValue($values, TRUE);
    }
  }

}
