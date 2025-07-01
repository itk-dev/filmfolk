<?php

namespace Drupal\filmfolk\Entity;

use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\taxonomy\Entity\Term as BaseTerm;

/**
 * Custom term.
 */
class Term extends BaseTerm {
  use StringTranslationTrait;

  /**
 * Override label to add extra info.
 */
  #[\Override]
  public function label() {
    $label = parent::label();

    $fields = $this->getFields();
    if (isset($fields['field_medlem_af_dvf']) && $fields['field_medlem_af_dvf']->getString()) {
      $label .= ' ' . $this->t('(member of DVF)');
    }

    return $label;
  }

}
