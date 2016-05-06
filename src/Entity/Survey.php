<?php

namespace Drupal\survey_manager\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;

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
 *     "delete-form" = "/admin/structure/survey/{survey}/delete",
 *     "edit-form" = "/admin/structure/survey/{survey}/edit",
 *     "collection" = "/admin/structure/survey"
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

  protected $code;

  public function getCode() {
    return $this->code;
  }

}