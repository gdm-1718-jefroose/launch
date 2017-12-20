<?php

namespace Drupal\launch\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Url;
use Drupal\launch\Entity\VehicleInterface;

/**
 * Class VehicleController.
 *
 *  Returns responses for Vehicle routes.
 */
class VehicleController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * Displays a Vehicle  revision.
   *
   * @param int $vehicle_revision
   *   The Vehicle  revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function revisionShow($vehicle_revision) {
    $vehicle = $this->entityManager()->getStorage('vehicle')->loadRevision($vehicle_revision);
    $view_builder = $this->entityManager()->getViewBuilder('vehicle');

    return $view_builder->view($vehicle);
  }

  /**
   * Page title callback for a Vehicle  revision.
   *
   * @param int $vehicle_revision
   *   The Vehicle  revision ID.
   *
   * @return string
   *   The page title.
   */
  public function revisionPageTitle($vehicle_revision) {
    $vehicle = $this->entityManager()->getStorage('vehicle')->loadRevision($vehicle_revision);
    return $this->t('Revision of %title from %date', ['%title' => $vehicle->label(), '%date' => format_date($vehicle->getRevisionCreationTime())]);
  }

  /**
   * Generates an overview table of older revisions of a Vehicle .
   *
   * @param \Drupal\launch\Entity\VehicleInterface $vehicle
   *   A Vehicle  object.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function revisionOverview(VehicleInterface $vehicle) {
    $account = $this->currentUser();
    $langcode = $vehicle->language()->getId();
    $langname = $vehicle->language()->getName();
    $languages = $vehicle->getTranslationLanguages();
    $has_translations = (count($languages) > 1);
    $vehicle_storage = $this->entityManager()->getStorage('vehicle');

    $build['#title'] = $has_translations ? $this->t('@langname revisions for %title', ['@langname' => $langname, '%title' => $vehicle->label()]) : $this->t('Revisions for %title', ['%title' => $vehicle->label()]);
    $header = [$this->t('Revision'), $this->t('Operations')];

    $revert_permission = (($account->hasPermission("revert all vehicle revisions") || $account->hasPermission('administer vehicle entities')));
    $delete_permission = (($account->hasPermission("delete all vehicle revisions") || $account->hasPermission('administer vehicle entities')));

    $rows = [];

    $vids = $vehicle_storage->revisionIds($vehicle);

    $latest_revision = TRUE;

    foreach (array_reverse($vids) as $vid) {
      /** @var \Drupal\launch\VehicleInterface $revision */
      $revision = $vehicle_storage->loadRevision($vid);
      // Only show revisions that are affected by the language that is being
      // displayed.
      if ($revision->hasTranslation($langcode) && $revision->getTranslation($langcode)->isRevisionTranslationAffected()) {
        $username = [
          '#theme' => 'username',
          '#account' => $revision->getRevisionUser(),
        ];

        // Use revision link to link to revisions that are not active.
        $date = \Drupal::service('date.formatter')->format($revision->getRevisionCreationTime(), 'short');
        if ($vid != $vehicle->getRevisionId()) {
          $link = $this->l($date, new Url('entity.vehicle.revision', ['vehicle' => $vehicle->id(), 'vehicle_revision' => $vid]));
        }
        else {
          $link = $vehicle->link($date);
        }

        $row = [];
        $column = [
          'data' => [
            '#type' => 'inline_template',
            '#template' => '{% trans %}{{ date }} by {{ username }}{% endtrans %}{% if message %}<p class="revision-log">{{ message }}</p>{% endif %}',
            '#context' => [
              'date' => $link,
              'username' => \Drupal::service('renderer')->renderPlain($username),
              'message' => ['#markup' => $revision->getRevisionLogMessage(), '#allowed_tags' => Xss::getHtmlTagList()],
            ],
          ],
        ];
        $row[] = $column;

        if ($latest_revision) {
          $row[] = [
            'data' => [
              '#prefix' => '<em>',
              '#markup' => $this->t('Current revision'),
              '#suffix' => '</em>',
            ],
          ];
          foreach ($row as &$current) {
            $current['class'] = ['revision-current'];
          }
          $latest_revision = FALSE;
        }
        else {
          $links = [];
          if ($revert_permission) {
            $links['revert'] = [
              'title' => $this->t('Revert'),
              'url' => $has_translations ?
              Url::fromRoute('entity.vehicle.translation_revert', ['vehicle' => $vehicle->id(), 'vehicle_revision' => $vid, 'langcode' => $langcode]) :
              Url::fromRoute('entity.vehicle.revision_revert', ['vehicle' => $vehicle->id(), 'vehicle_revision' => $vid]),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('entity.vehicle.revision_delete', ['vehicle' => $vehicle->id(), 'vehicle_revision' => $vid]),
            ];
          }

          $row[] = [
            'data' => [
              '#type' => 'operations',
              '#links' => $links,
            ],
          ];
        }

        $rows[] = $row;
      }
    }

    $build['vehicle_revisions_table'] = [
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    ];

    return $build;
  }

}
