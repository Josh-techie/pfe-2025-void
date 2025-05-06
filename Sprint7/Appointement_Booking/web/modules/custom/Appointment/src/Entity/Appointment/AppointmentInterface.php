<?php

namespace Drupal\appointment\Entity\Appointment;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for appointment entities.
 */
interface AppointmentInterface extends ContentEntityInterface, EntityChangedInterface
{

  /**
   * Gets the appointment title.
   *
   * @return string
   *   Title of the appointment.
   */
  public function getTitle();

  /**
   * Sets the appointment title.
   *
   * @param string $title
   *   The appointment title.
   *
   * @return \Drupal\appointment\Entity\Appointment\AppointmentInterface
   *   The called appointment entity.
   */
  public function setTitle($title);

  /**
   * Gets the appointment creation timestamp.
   *
   * @return int
   *   Creation timestamp of the appointment.
   */
  public function getCreatedTime();

  /**
   * Sets the appointment creation timestamp.
   *
   * @param int $timestamp
   *   The appointment creation timestamp.
   *
   * @return \Drupal\appointment\Entity\Appointment\AppointmentInterface
   *   The called appointment entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Gets the appointment date.
   *
   * @return \Drupal\Core\Datetime\DrupalDateTime
   *   The appointment date.
   */
  public function getAppointmentDate();

  /**
   * Sets the appointment date.
   *
   * @param string $date
   *   The appointment date.
   *
   * @return \Drupal\appointment\Entity\Appointment\AppointmentInterface
   *   The called appointment entity.
   */
  public function setAppointmentDate($date);

  /**
   * Gets the appointment status.
   *
   * @return int
   *   The appointment status.
   */
  public function getStatus();

  /**
   * Sets the appointment status.
   *
   * @param int $status
   *   The appointment status.
   *
   * @return \Drupal\appointment\Entity\Appointment\AppointmentInterface
   *   The called appointment entity.
   */
  public function setStatus($status);

  /**
   * Gets the client first name.
   *
   * @return string
   *   The client first name.
   */
  public function getFirstName();

  /**
   * Sets the client first name.
   *
   * @param string $first_name
   *   The client first name.
   *
   * @return \Drupal\appointment\Entity\Appointment\AppointmentInterface
   *   The called appointment entity.
   */
  public function setFirstName($first_name);

  /**
   * Gets the client last name.
   *
   * @return string
   *   The client last name.
   */
  public function getLastName();

  /**
   * Sets the client last name.
   *
   * @param string $last_name
   *   The client last name.
   *
   * @return \Drupal\appointment\Entity\Appointment\AppointmentInterface
   *   The called appointment entity.
   */
  public function setLastName($last_name);

  /**
   * Gets the client email.
   *
   * @return string
   *   The client email.
   */
  public function getEmail();

  /**
   * Sets the client email.
   *
   * @param string $email
   *   The client email.
   *
   * @return \Drupal\appointment\Entity\Appointment\AppointmentInterface
   *   The called appointment entity.
   */
  public function setEmail($email);

  /**
   * Gets the client phone.
   *
   * @return string
   *   The client phone.
   */
  public function getPhone();

  /**
   * Sets the client phone.
   *
   * @param string $phone
   *   The client phone.
   *
   * @return \Drupal\appointment\Entity\Appointment\AppointmentInterface
   *   The called appointment entity.
   */
  public function setPhone($phone);

}
