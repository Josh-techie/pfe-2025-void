<?php

namespace Drupal\appointment;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Url;

/**
 * Defines a class to build a listing of Agency entities.
 */
class AgencyListBuilder extends EntityListBuilder
{

  /**
   * {@inheritdoc}
   */
  public function buildHeader()
  {
    $header['id'] = $this->t('ID');
    $header['name'] = $this->t('Name');
    $header['address'] = $this->t('Address');
    $header['phone'] = $this->t('Phone');
    $header['email'] = $this->t('Email');
    $header['status'] = $this->t('Status');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity)
  {
    /** @var \Drupal\appointment\Entity\Agency\Agency $entity */
    $row['id'] = $entity->id();
    $row['name'] = $entity->toLink();
    $row['address'] = $entity->get('address')->value;
    $row['phone'] = $entity->get('phone')->value;
    $row['email'] = $entity->get('email')->value;
    $row['status'] = $entity->get('status')->value ? $this->t('Active') : $this->t('Inactive');
    return $row + parent::buildRow($entity);
  }

  /**
   * {@inheritdoc}
   */
  public function getDefaultOperations(EntityInterface $entity)
  {
    $operations = parent::getDefaultOperations($entity);

    $url = Url::fromRoute('view.appointments.page_1', [
      'agency' => $entity->id(),
    ]);

    $operations['view_appointments'] = [
      'title' => $this->t('View Appointments'),
      'weight' => 100,
      'url' => $url,
    ];

    return $operations;
  }

}
