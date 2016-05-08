<?php

namespace Drupal\survey_manager\Entity;

use Drupal\survey_manager\Entity\Survey;

/**
 * @configEntityType(
 *   id = "survey_embed",
 *   label = @Translation("Survey embed"),
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
 *     "collection" = "/admin/structure/survey-embed",
 *     "edit-form" = "/admin/structure/survey-embed/{survey}/edit",
 *     "delete-form" = "/admin/structure/survey-embed/{survey}/delete",
 *   },
 *   entity_export = {
 *     "id",
 *     "label",
 *     "code",
 *     "visibility"
 *   },
 * )
 */
class SurveyEmbed extends Survey implements SurveyInterface {

  protected $type = 'EMBED';

}