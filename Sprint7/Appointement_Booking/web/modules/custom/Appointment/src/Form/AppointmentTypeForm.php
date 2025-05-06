<?php

namespace Drupal\appointment\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides the appointment type selection form for the multi-step appointment booking.
 */
class AppointmentTypeForm extends FormBase
{

  /**
   * {@inheritdoc}
   */
  public function getFormId()
  {
    return 'appointment_type_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state)
  {
    $form['appointment_type'] = [
      '#type' => 'radios',
      '#title' => $this->t('Select Appointment Type'),
      '#options' => [
        'business_appointment' => $this->t('Business Appointment'),
        'professional_staff' => $this->t('Professional Staff'),
      ],
      '#required' => TRUE,
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    // This method is intentionally left blank.
  }

}
