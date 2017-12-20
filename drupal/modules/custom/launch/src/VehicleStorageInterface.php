<?php

namespace Drupal\launch;

use Drupal\Core\Entity\ContentEntityStorageInterface;
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
interface VehicleStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of Vehicle revision IDs for a specific Vehicle.
   *
   * @param \Drupal\launch\Entity\VehicleInterface $entity
   *   The Vehicle entity.
   *
   * @return int[]
   *   Vehicle revision IDs (in ascending order).
   */
  public function revisionIds(VehicleInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as Vehicle author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   Vehicle revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\launch\Entity\VehicleInterface $entity
   *   The Vehicle entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(VehicleInterface $entity);

  /**
   * Unsets the language for all Vehicle with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

}
