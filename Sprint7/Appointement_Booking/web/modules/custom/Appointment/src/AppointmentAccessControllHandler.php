<?php

namespace Drupal\appointment;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Appointment entity.
 */
class AppointmentAccessControlHandler extends EntityAccessControlHandler
{

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account)
  {
    // Admin always has access.
    if ($account->hasPermission('administer appointment entities')) {
      return AccessResult::allowed()->cachePerPermissions();
    }

    // Adviser can view and edit appointments assigned to them.
    if (
      $account->hasPermission('access adviser appointments') &&
      $operation == 'view' &&
      $entity->get('adviser')->target_id == $account->id()
    ) {
      return AccessResult::allowed()->cachePerPermissions()->cachePerUser();
    }

    // Check standard permissions.
    switch ($operation) {
      case 'view':
        return AccessResult::allowedIfHasPermission($account, 'view appointment entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit appointment entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete appointment entities');
    }

    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL)
  {
    return AccessResult::allowedIfHasPermission($account, 'add appointment entities')
      ->orIf(AccessResult::allowedIfHasPermission($account, 'book appointments'));
  }

}
