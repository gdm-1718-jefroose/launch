<?php

namespace Drupal\launch\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Vehicle entities.
 *
 * @ingroup launch
 */
interface VehicleInterface extends ContentEntityInterface, RevisionLogInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Vehicle name.
   *
   * @return string
   *   Name of the Vehicle.
   */
  public function getName();

  /**
   * Sets the Vehicle name.
   *
   * @param string $name
   *   The Vehicle name.
   *
   * @return \Drupal\launch\Entity\VehicleInterface
   *   The called Vehicle entity.
   */
  public function setName($name);

  /**
   * Gets the Vehicle creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Vehicle.
   */
  public function getCreatedTime();

  /**
   * Sets the Vehicle creation timestamp.
   *
   * @param int $timestamp
   *   The Vehicle creation timestamp.
   *
   * @return \Drupal\launch\Entity\VehicleInterface
   *   The called Vehicle entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Vehicle published status indicator.
   *
   * Unpublished Vehicle are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Vehicle is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Vehicle.
   *
   * @param bool $published
   *   TRUE to set this Vehicle to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\launch\Entity\VehicleInterface
   *   The called Vehicle entity.
   */
  public function setPublished($published);

  /**
   * Gets the Vehicle revision creation timestamp.
   *
   * @return int
   *   The UNIX timestamp of when this revision was created.
   */
  public function getRevisionCreationTime();

  /**
   * Sets the Vehicle revision creation timestamp.
   *
   * @param int $timestamp
   *   The UNIX timestamp of when this revision was created.
   *
   * @return \Drupal\launch\Entity\VehicleInterface
   *   The called Vehicle entity.
   */
  public function setRevisionCreationTime($timestamp);

  /**
   * Gets the Vehicle revision author.
   *
   * @return \Drupal\user\UserInterface
   *   The user entity for the revision author.
   */
  public function getRevisionUser();

  /**
   * Sets the Vehicle revision author.
   *
   * @param int $uid
   *   The user ID of the revision author.
   *
   * @return \Drupal\launch\Entity\VehicleInterface
   *   The called Vehicle entity.
   */
  public function setRevisionUserId($uid);

}
