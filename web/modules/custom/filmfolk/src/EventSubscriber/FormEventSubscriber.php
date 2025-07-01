<?php

declare(strict_types=1);

namespace Drupal\filmfolk\EventSubscriber;

use Drupal\Component\Render\MarkupInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\core_event_dispatcher\Event\Form\FormAlterEvent;
use Drupal\core_event_dispatcher\FormHookEvents;
use Drupal\filmfolk\Helper;
use Drupal\filmfolk\Plugin\Field\FieldType\FunktionErfaringItem;
use Drupal\user\ProfileForm;
use Drupal\user\UserInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Form event subscriber.
 */
final class FormEventSubscriber implements EventSubscriberInterface {

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

      case 'user_register_form':
        $this->userRegisterFormAlter($event);
        break;

      case 'user_form':
        $this->userFormAlter($event);
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

  /**
   * User register form alter.
   */
  private function userRegisterFormAlter(FormAlterEvent $event) {
    if ('user.admin_create' === $this->routeMatch->getRouteName()) {
      $form = &$event->getForm();
      if (in_array(Helper::ROLE_PERSON_MANAGER, $this->account->getRoles())) {
        // Default to inactive account.
        $form['account']['status']['#default_value'] = 0;
        // Check the person role.
        $form['account']['roles']['#default_value'][] = Helper::ROLE_PERSON;
        $this->userFormAlter($event);
      }
      else {
        // Hide the person profile from non-person managers.
        unset($form['person_profiles']);
      }
    }
  }

  /**
   * User form alter.
   */
  private function userFormAlter(FormAlterEvent $event) {
    $form = &$event->getForm();

    // Hide language selector for all users but user 1 (and 0).
    if ($this->account->isAnonymous() || $this->account->id() > 1) {
      $form['language']['#access'] = FALSE;
    }

    // Hide password if not editing own account.
    $formObject = $event->getFormState()->getFormObject();
    if ($formObject instanceof ProfileForm) {
      $user = $formObject->getEntity();
      if ($user instanceof UserInterface && $this->account->id() !== $user->id()) {
        $form['account']['pass']['#access'] = FALSE;
        $form['account']['pass']['#required'] = FALSE;
      }
    }

    if (in_array(Helper::ROLE_PERSON_MANAGER, $this->account->getRoles())) {
      // Hide roles selector.
      $form['account']['roles']['#access'] = FALSE;
    }
  }

}
