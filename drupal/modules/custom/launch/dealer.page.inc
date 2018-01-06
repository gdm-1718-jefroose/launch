<?php

/**
 * @file
 * Contains dealer.page.inc.
 *
 * Page callback for Dealer entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Dealer templates.
 *
 * Default template: dealer.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_dealer(array &$variables) {
  // Fetch Dealer Entity Object.
  $dealer = $variables['elements']['#dealer'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
