<?php

namespace Drupal\launch\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Dealer entities.
 *
 * @ingroup launch
 */
interface DealerInterface extends ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Dealer name.
   *
   * @return string
   *   Name of the Dealer.
   */
  public function getName();

  /**
   * Sets the Dealer name.
   *
   * @param string $name
   *   The Dealer name.
   *
   * @return \Drupal\launch\Entity\DealerInterface
   *   The called Dealer entity.
   */
  public function setName($name);

  /**
   * Gets the Dealer creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Dealer.
   */
  public function getCreatedTime();

  /**
   * Sets the Dealer creation timestamp.
   *
   * @param int $timestamp
   *   The Dealer creation timestamp.
   *
   * @return \Drupal\launch\Entity\DealerInterface
   *   The called Dealer entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Dealer published status indicator.
   *
   * Unpublished Dealer are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Dealer is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Dealer.
   *
   * @param bool $published
   *   TRUE to set this Dealer to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\launch\Entity\DealerInterface
   *   The called Dealer entity.
   */
  public function setPublished($published);

}
