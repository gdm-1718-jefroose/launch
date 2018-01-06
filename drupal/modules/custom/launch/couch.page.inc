<?php

/**
 * @file
 * Contains couch.page.inc.
 *
 * Page callback for Couch entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Couch templates.
 *
 * Default template: couch.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_couch(array &$variables) {
  // Fetch Couch Entity Object.
  $couch = $variables['elements']['#couch'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
