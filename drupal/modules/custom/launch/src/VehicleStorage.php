<?php

namespace Drupal\launch;

use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\launch\Entity\VehicleInterface;

/**
 * Defines the storage handler class for Vehicle entities.
 *
 * This extends the base storage class, adding required special handling for
 * Vehicle entities.
 *
 * @ingroup launch
 */
class VehicleStorage extends SqlContentEntityStorage implements VehicleStorageInterface {

  /**
   * {@inheritdoc}
   */
  public function revisionIds(VehicleInterface $entity) {
    return $this->database->query(
      'SELECT vid FROM {vehicle_revision} WHERE id=:id ORDER BY vid',
      [':id' => $entity->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function userRevisionIds(AccountInterface $account) {
    return $this->database->query(
      'SELECT vid FROM {vehicle_field_revision} WHERE uid = :uid ORDER BY vid',
      [':uid' => $account->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function countDefaultLanguageRevisions(VehicleInterface $entity) {
    return $this->database->query('SELECT COUNT(*) FROM {vehicle_field_revision} WHERE id = :id AND default_langcode = 1', [':id' => $entity->id()])
      ->fetchField();
  }

  /**
   * {@inheritdoc}
   */
  public function clearRevisionsLanguage(LanguageInterface $language) {
    return $this->database->update('vehicle_revision')
      ->fields(['langcode' => LanguageInterface::LANGCODE_NOT_SPECIFIED])
      ->condition('langcode', $language->getId())
      ->execute();
  }

}
