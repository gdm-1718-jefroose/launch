<?php

namespace Drupal\launch;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Dealer entity.
 *
 * @see \Drupal\launch\Entity\Dealer.
 */
class DealerAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\launch\Entity\DealerInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished dealer entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published dealer entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit dealer entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete dealer entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add dealer entities');
  }

}
