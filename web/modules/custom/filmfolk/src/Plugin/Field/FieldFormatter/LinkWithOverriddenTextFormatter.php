<?php

declare(strict_types=1);

namespace Drupal\filmfolk\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\Attribute\FieldFormatter;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\link\Plugin\Field\FieldFormatter\LinkFormatter;

/**
 * Plugin implementation of the 'Link with overridden text' formatter.
 */
#[FieldFormatter(
  id: 'filmfolk_link_with_overridden_text',
  label: new TranslatableMarkup('Link with overridden text'),
  field_types: [
    'link',
  ],
)]
final class LinkWithOverriddenTextFormatter extends LinkFormatter {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings(): array {
    $setting = [
      'use_field_label_as_link_text' => FALSE,
      'link_text' => '',
    ];
    return $setting + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state): array {
    $elements['use_field_label_as_link_text'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Use field label as link text'),
      '#default_value' => $this->getSetting('use_field_label_as_link_text'),
    ];
    $elements['link_text'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Link text'),
      '#default_value' => $this->getSetting('link_text'),
      '#states' => [
        'visible' => [
          ':input[name="fields[field_person_imdb_link][settings_edit_form][settings][use_field_label_as_link_text]"]' => ['checked' => FALSE],
        ],
      ],
    ];
    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary(): array {
    return [
      $this->getSetting('use_field_label_as_link_text')
        ? $this->t('Use field label as link text')
        : $this->t('Link text: @link_text', ['@link_text' => $this->getSetting('link_text')]),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode): array {
    $text =
      $this->getSetting('use_field_label_as_link_text')
      ? $this->fieldDefinition->getLabel()
        : $this->getSetting('link_text');
    if (!empty(trim($text))) {
      /** @var \Drupal\link\Plugin\Field\FieldType\LinkItem $item */
      foreach ($items as $item) {
        $item->set('title', $text);
      }
    }
    return parent::viewElements($items, $langcode);
  }

}
