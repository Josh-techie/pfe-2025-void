<?php

namespace Drupal\appointment\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides the advisor selection form for the multi-step appointment booking.
 */
class AppointmentAdvisorForm extends FormBase
{

  /**
   * {@inheritdoc}
   */
  public function getFormId()
  {
    return 'appointment_advisor_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state)
  {
    $selected_agency = $form_state->get('selected_agency');

    $form['adviser'] = [
      '#type' => 'select',
      '#title' => $this->t('Select Advisor'),
      '#options' => $this->getAdviserOptions($selected_agency),
      '#required' => TRUE,
    ];

    return $form;
  }

  /**
   * Helper function to get adviser options.
   *
   * @param int $agency_id
   *   The ID of the selected agency.
   *
   * @return array
   *   An array of adviser options.
   */
  protected function getAdviserOptions($agency_id = NULL)
  {
    $options = [];
    if ($agency_id) {
      $query = \Drupal::entityQuery('user')
        ->condition('status', 1)
        ->condition('roles', 'adviser')
        ->condition('field_agency', $agency_id);
      $uids = $query->execute();
      $users = \Drupal::entityTypeManager()->getStorage('user')->loadMultiple($uids);
      foreach ($users as $user) {
        $options[$user->id()] = $user->getDisplayName();
      }
    } else {
      $options[0] = $this->t('Select Agency First');
    }
    return $options;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    // This method is intentionally left blank.
  }

}
