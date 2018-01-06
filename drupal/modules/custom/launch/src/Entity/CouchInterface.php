<?php

namespace Drupal\launch\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Couch entities.
 *
 * @ingroup launch
 */
interface CouchInterface extends ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Couch name.
   *
   * @return string
   *   Name of the Couch.
   */
  public function getName();

  /**
   * Sets the Couch name.
   *
   * @param string $name
   *   The Couch name.
   *
   * @return \Drupal\launch\Entity\CouchInterface
   *   The called Couch entity.
   */
  public function setName($name);

  /**
   * Gets the Couch creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Couch.
   */
  public function getCreatedTime();

  /**
   * Sets the Couch creation timestamp.
   *
   * @param int $timestamp
   *   The Couch creation timestamp.
   *
   * @return \Drupal\launch\Entity\CouchInterface
   *   The called Couch entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Couch published status indicator.
   *
   * Unpublished Couch are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Couch is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Couch.
   *
   * @param bool $published
   *   TRUE to set this Couch to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\launch\Entity\CouchInterface
   *   The called Couch entity.
   */
  public function setPublished($published);

}
