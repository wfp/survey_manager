<?php

namespace Drupal\survey_manager\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;
use Drupal\node\Entity\Node;

/**
 * @configEntityType(
 *   id = "survey",
 *   label = @Translation("Survey"),
 *   handlers = {
 *     "list_builder" = "Drupal\survey_manager\SurveyListBuilder",
 *     "form" = {
 *       "add" = "Drupal\survey_manager\Form\SurveyForm",
 *       "edit" = "Drupal\survey_manager\Form\SurveyForm",
 *       "delete" = "Drupal\Core\Entity\EntityDeleteForm"
 *     }
 *   },
 *   admin_permission = "administer survey",
 *   config_prefix = "survey",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label"
 *   },
 *   links = {
 *     "collection" = "/admin/structure/survey",
 *     "edit-form" = "/admin/structure/survey/{survey}/edit",
 *     "delete-form" = "/admin/structure/survey/{survey}/delete",
 *   },
 *   entity_export = {
 *     "id",
 *     "label",
 *     "code",
 *     "visibility"
 *   },
 * )
 */
class Survey extends ConfigEntityBase implements SurveyInterface {

  protected $type = 'HTML';

  protected $code;

  protected $visibility = [];

  public function getCode() {
    return $this->code;
  }

  public function getType() {
    return $this->type;
  }

  public function getVisibility() {
    return $this->visibility;
  }

  public function accessable() {
    $user_current = \Drupal::currentUser();
    $path_current = \Drupal::service('path.current')->getPath();

    $visibility = $this->getVisibility();
    $pages = array_filter(explode(' ', $visibility['pages']));
    $content_types = array_filter($visibility['content_types']);
    $user_roles = array_values(array_filter($visibility['user_roles']));

    if ($pages) {
      $accessable['page'] = FALSE;
      $pages = str_replace('<front>', '/node', $pages);
      if (in_array($path_current, $pages)) {
        $accessable['page'] = TRUE;
      }
    }
    elseif ($content_types) {
      $accessable['content_type'] = FALSE;
      if (preg_match('/^\/node\/(\d+)$/', $path_current, $result)) {
        if (isset($result[1]) && is_numeric($result[1])) {
          $id = (int) $result[1];
          $node = Node::load($id);

          if (in_array($node->bundle(), $content_types)) {
            $accessable['content_type'] = TRUE;
          }
        }
      }
    }

    if ($user_roles) {
      $accessable['user_role'] = FALSE;
      if (array_intersect($user_current->getRoles(), $user_roles)) {
        $accessable['user_role'] = TRUE;
      }
    }

    if (!$accessable) {
      return FALSE;
    }

    foreach ($accessable as $access) {
      if (!$access) {
        return FALSE;
      }
    }

    return TRUE;
  }

}