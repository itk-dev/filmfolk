<?php

declare(strict_types=1);

namespace Drupal\filmfolk\Plugin\Field\FieldWidget;

use Drupal\Core\Field\Attribute\FieldWidget;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\filmfolk\Helper;
use Drupal\filmfolk\Plugin\Field\FieldType\FunktionErfaringItem;
use Drupal\taxonomy\Entity\Term;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Defines the 'filmfolk_funktion_erfaring' field widget.
 */
#[FieldWidget(
  id: 'filmfolk_funktion_erfaring',
  label: new TranslatableMarkup('funktion_erfaring'),
  field_types: ['filmfolk_funktion_erfaring'],
)]
final class FunktionErfaringWidget extends WidgetBase {
  use StringTranslationTrait;

  public function __construct(
    $plugin_id,
    $plugin_definition,
    FieldDefinitionInterface $field_definition,
    array $settings,
    array $third_party_settings,
    private readonly Helper $helper,
  ) {
    parent::__construct($plugin_id, $plugin_definition, $field_definition, $settings, $third_party_settings);
  }

  /**
   * {@inheritdoc}
   */
  #[\Override]
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
    $plugin_id,
    $plugin_definition,
    $configuration['field_definition'],
    $configuration['settings'],
    $configuration['third_party_settings'],
    $container->get(Helper::class),
    );
  }

  /**
   * {@inheritdoc}
   */
  #[\Override]
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state): array {
    $element[FunktionErfaringItem::PROPERTY_FUNKTION_TARGET_ID] = [
      '#type' => 'select',
      '#title' => $this->t('Funktion'),
      '#required' => $element['#required'],
      '#empty_value' => '',
      '#empty_option' => $this->t('Select funktion'),
      '#options' => array_map(static fn (Term $term) => $term->label(), $this->helper->loadTerms(Helper::TAXONOMY_FUNKTION)),
      '#default_value' => $items[$delta]->get(FunktionErfaringItem::PROPERTY_FUNKTION_TARGET_ID)?->getString() ?: NULL,
    ];

    $element[FunktionErfaringItem::PROPERTY_ERFARING_TARGET_ID] = [
      '#type' => 'select',
      '#title' => $this->t('Erfaring'),
      '#required' => $element['#required'],
      '#empty_value' => '',
      '#empty_option' => $this->t('Select erfaring'),
      '#options' => array_map(static fn (Term $term) => $term->label(), $this->helper->loadTerms(Helper::TAXONOMY_ERFARING)),
      '#default_value' => $items[$delta]->get(FunktionErfaringItem::PROPERTY_ERFARING_TARGET_ID)?->getString() ?: NULL,
    ];

    return $element;
  }

}
