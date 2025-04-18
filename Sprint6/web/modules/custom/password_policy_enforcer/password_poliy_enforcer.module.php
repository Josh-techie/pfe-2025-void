<?php

use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;

/**
 * Implements hook_entity_base_field_info_alter().
 *
 * @param \Drupal\Core\Field\BaseFieldDefinition[] $fields
 *   An array of base field definitions.
 * @param \Drupal\Core\Entity\EntityTypeInterface $entity_type
 *   The entity type.
 */
function password_policy_enforcer_entity_base_field_info_alter(array &$fields, EntityTypeInterface $entity_type)
{
  // Only alter the user entity type.
  if ($entity_type->id() === 'user') {
    // Check if the password field exists.
    if (isset($fields['pass'])) {
      // Add the PasswordPolicyConstraint to the password field.
      // Drupal now uses PasswordPolicyConstraint not PasswordPolicy
      // from the Drupal11 version!
      $fields['pass']->addConstraint('Drupal\password_policy\Plugin\Validation\Constraint\PasswordPolicyConstraint');
    }
  }
}
