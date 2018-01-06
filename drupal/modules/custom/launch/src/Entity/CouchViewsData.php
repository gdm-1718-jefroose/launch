<?php

namespace Drupal\launch\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Couch entities.
 */
class CouchViewsData extends EntityViewsData {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    // Additional information for Views integration, such as table joins, can be
    // put here.

    return $data;
  }

}
