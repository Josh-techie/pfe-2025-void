<?php

namespace Drupal\appointment\Entity\Appointment;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Appointment entities.
 */
class AppointmentViewsData extends EntityViewsData
{

  /**
   * {@inheritdoc}
   */
  public function getViewsData()
  {
    $data = parent::getViewsData();

    // Additional information for Views integration.
    $data['appointment']['table']['base'] = [
      'field' => 'id',
      'title' => $this->t('Appointment'),
      'help' => $this->t('The Appointment entity ID.'),
    ];

    // Add relationship to agency entity.
    $data['appointment']['agency']['relationship'] = [
      'base' => 'agency',
      'base field' => 'id',
      'field' => 'agency',
      'id' => 'standard',
      'label' => $this->t('Agency'),
      'title' => $this->t('Agency'),
      'help' => $this->t('Reference to the agency.'),
    ];

    // Add relationship to user entity for adviser.
    $data['appointment']['adviser']['relationship'] = [
      'base' => 'users_field_data',
      'base field' => 'uid',
      'field' => 'adviser',
      'id' => 'standard',
      'label' => $this->t('Adviser'),
      'title' => $this->t('Adviser'),
      'help' => $this->t('Reference to the adviser user.'),
    ];

    // Add relationship to taxonomy term for appointment type.
    $data['appointment']['appointment_type']['relationship'] = [
      'base' => 'taxonomy_term_field_data',
      'base field' => 'tid',
      'field' => 'appointment_type',
      'id' => 'standard',
      'label' => $this->t('Appointment Type'),
      'title' => $this->t('Appointment Type'),
      'help' => $this->t('Reference to the appointment type.'),
    ];

    // Add custom filters for appointment status.
    $data['appointment']['status']['filter']['id'] = 'list_field';

    // Add custom filter for appointment date.
    $data['appointment']['date']['filter']['id'] = 'datetime';

    return $data;
  }

}
