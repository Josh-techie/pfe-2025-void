<?php

namespace Drupal\appointment\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a multi-step appointment booking form.
 */
class AppointmentMultiStepForm extends FormBase
{

  /**
   * {@inheritdoc}
   */
  public function getFormId()
  {
    return 'appointment_multistep_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state)
  {
    // Get the current step from the form state.
    $step = $form_state->get('step') ?: 1;

    $form['step'] = [
      '#type' => 'value',
      '#value' => $step,
    ];

    // Step 1: Agency Selection
    $form['agency'] = [
      '#type' => 'select',
      '#title' => $this->t('Select Agency'),
      '#options' => $this->getAgencyOptions(),
      '#required' => TRUE,
      '#access' => ($step == 1), // Only show on step 1
    ];

    // Step 2: Appointment Type Selection
    $form['appointment_type'] = [
      '#type' => 'radios',
      '#title' => $this->t('Select Appointment Type'),
      '#options' => [
        'business_appointment' => $this->t('Business Appointment'),
        'professional_staff' => $this->t('Professional Staff'),
      ],
      '#required' => TRUE,
      '#access' => ($step == 2), // Only show on step 2
    ];

    $form['actions'] = [
      '#type' => 'actions',
    ];

    $form['actions']['previous'] = [
      '#type' => 'submit',
      '#value' => $this->t('Previous'),
      '#states' => [
        'visible' => [
          ':input[name="step"]' => ['!value' => 1],
        ],
      ],
      '#submit' => ['::previousStep'],
      '#access' => $step > 1,
    ];

    $form['actions']['next'] = [
      '#type' => 'submit',
      '#value' => $this->t('Next'),
      '#submit' => ['::nextStep'],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    $step = $form_state->getValue('step');

    if ($step == 1) {
      $selected_agency = $form_state->getValue('agency');
      $form_state->set('selected_agency', $selected_agency);
    } elseif ($step == 2) {
      $selected_appointment_type = $form_state->getValue('appointment_type');
      $form_state->set('selected_appointment_type', $selected_appointment_type);
    }
  }

  /**
   * {@inheritdoc}
   */
  public function nextStep(array &$form, FormStateInterface $form_state)
  {
    $step = $form_state->getValue('step');
    $form_state->set('step', $step + 1);
    $form_state->setRebuild();
  }

  /**
   * {@inheritdoc}
   */
  public function previousStep(array &$form, FormStateInterface $form_state)
  {
    $step = $form_state->getValue('step');
    $form_state->set('step', $step - 1);
    $form_state->setRebuild();
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
}
