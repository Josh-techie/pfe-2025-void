<?php

namespace Drupal\appointment;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Datetime\DateFormatterInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Link;
use Drupal\Core\Url;

/**
 * Defines a class to build a listing of Appointment entities.
 */
class AppointmentListBuilder extends EntityListBuilder
{

  /**
   * The date formatter service.
   *
   * @var \Drupal\Core\Datetime\DateFormatterInterface
   */
  protected $dateFormatter;

  /**
   * Constructs a new AppointmentListBuilder object.
   *
   * @param \Drupal\Core\Entity\EntityTypeInterface $entity_type
   *   The entity type definition.
   * @param \Drupal\Core\Entity\EntityStorageInterface $storage
   *   The entity storage class.
   * @param \Drupal\Core\Datetime\DateFormatterInterface $date_formatter
   *   The date formatter service.
   */
  public function __construct(EntityTypeInterface $entity_type, EntityStorageInterface $storage, DateFormatterInterface $date_formatter)
  {
    parent::__construct($entity_type, $storage);
    $this->dateFormatter = $date_formatter;
  }

  /**
   * {@inheritdoc}
   */
  public static function createInstance(ContainerInterface $container, EntityTypeInterface $entity_type)
  {
    return new static(
      $entity_type,
      $container->get('entity_type.manager')->getStorage($entity_type->id()),
      $container->get('date.formatter')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function buildHeader()
  {
    $header['id'] = $this->t('ID');
    $header['title'] = $this->t('Title');
    $header['agency'] = $this->t('Agency');
    $header['adviser'] = $this->t('Adviser');
    $header['client'] = $this->t('Client');
    $header['date'] = $this->t('Date');
    $header['status'] = $this->t('Status');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity)
  {
    /** @var \Drupal\appointment\Entity\Appointment\Appointment $entity */
    $row['id'] = $entity->id();
    $row['title'] = $entity->toLink();

    $agency = $entity->get('agency')->entity;
    $row['agency'] = $agency ? $agency->toLink() : $this->t('None');

    $adviser = $entity->get('adviser')->entity;
    $row['adviser'] = $adviser ? $adviser->toLink() : $this->t('None');

    $client_name = $entity->get('first_name')->value . ' ' . $entity->get('last_name')->value;
    $row['client'] = $client_name;

    $date = $entity->get('date')->value;
    $row['date'] = $date ? $this->dateFormatter->format(strtotime($date), 'medium') : $this->t('Not scheduled');

    $status_values = [
      1 => $this->t('Pending'),
      2 => $this->t('Confirmed'),
      3 => $this->t('Completed'),
      4 => $this->t('Cancelled'),
      5 => $this->t('Rescheduled'),
    ];

    $status = $entity->get('status')->value;
    $row['status'] = isset($status_values[$status]) ? $status_values[$status] : $this->t('Unknown');

    return $row + parent::buildRow($entity);
  }

  /**
   * {@inheritdoc}
   */
  protected function getDefaultOperations(EntityInterface $entity)
  {
    $operations = parent::getDefaultOperations($entity);

    $operations['export'] = [
      'title' => $this->t('Export'),
      'weight' => 50,
      'url' => Url::fromRoute('appointment.export_single', ['appointment' => $entity->id()]),
    ];

    return $operations;
  }

}
