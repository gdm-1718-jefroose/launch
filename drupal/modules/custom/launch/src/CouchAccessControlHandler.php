<?php

namespace Drupal\launch;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Couch entity.
 *
 * @see \Drupal\launch\Entity\Couch.
 */
class CouchAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\launch\Entity\CouchInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished couch entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published couch entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit couch entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete couch entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add couch entities');
  }

}
