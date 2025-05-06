<?php

namespace Drupal\appointment\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides the agency selection form for the multi-step appointment booking.
 */
class AppointmentAgencyForm extends FormBase
{

  /**
   * {@inheritdoc}
   */
  public function getFormId()
  {
    return 'appointment_agency_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state)
  {
    $form['agency'] = [
      '#type' => 'select',
      '#title' => $this->t('Select Agency'),
      '#options' => $this->getAgencyOptions(),
      '#required' => TRUE,
    ];

    return $form;
  }

  /**
   * Helper function to get agency options.
   *
   * @return array
   *   An array of agency options.
   */
  protected function getAgencyOptions()
  {
    $agencies = \Drupal::entityTypeManager()->getStorage('agency')->loadMultiple();
    $options = [];
    foreach ($agencies as $agency) {
      $options[$agency->id()] = $agency->label();
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
