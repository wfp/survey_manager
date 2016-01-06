<?php

/**
 * @file
 * Contains \Drupal\survey_manager\Controller\SurveyListController.
 */

namespace Drupal\survey_manager\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;

/**
 * Class SurveyListController.
 *
 * @package Drupal\survey_manager\Controller
 */
class SurveyListController extends ControllerBase {

  /**
   * Index.
   *
   * @return string
   *   Return Hello string.
   */
  public function index() {
    $surveys_table = array(
      '#type'   => 'table',
      '#header' => array(
        t('Name'),
        t('Sections'),
        t('Type'),
        t('Manage'),
      ),
      '#empty'  => t('There are no surveys added. Add new surveys by <a href="@url">adding a new survey block.</a>', array('@url' => Url::fromRoute('block.admin_display')->toString()))
    );

    $embed_surveys = _survey_manager_get_surveys('survey_embed_code_block');
    $html_surveys  = _survey_manager_get_surveys('survey_htmlblock');

    $surveys = array_merge($embed_surveys, $html_surveys);

    $manager     = \Drupal::service('plugin.manager.block');
    $definitions = $manager->getDefinitions();

    foreach ($surveys as $id => $survey) {
      $plugin_id = $survey->get('settings')['id'];

      $surveys_table[$id]['name'] = array(
        '#plain_text' => $survey->get('settings')['label'],
      );

      $sections   = "";
      $visibility = $survey->getVisibility();

      if (!empty($visibility['request_path'])) {
        $pages = explode(PHP_EOL, $visibility['request_path']['pages']);
        $sections .= "Pages : " . implode(", ", $pages) . "</br>";
      }

      if (!empty($visibility['node_type'])) {
        $sections .= "Content Types : " . implode(", ",
            $visibility['node_type']['bundles']) . "</br>";
      }

      if (!empty($visibility['user_role'])) {
        $sections .= "Roles: " . implode(", ",
            $visibility['user_role']['roles']) . "</br>";
      }

      $surveys_table[$id]['sections'] = array(
        '#markup' => $sections,
      );

      $surveys_table[$id]['type'] = array(
        '#plain_text' => $definitions[$plugin_id]['admin_label']->getUntranslatedString(),
      );

      $surveys_table[$id]['operations'] = array(
        '#type'  => 'operations',
        '#links' => array(),
      );

      if (!empty($survey->get('settings')['manage_survey'])) {
        $surveys_table[$id]['operations']['#links']['manage'] = array(
          'title' => t('Manage'),
          'url'   => Url::fromUri($survey->get('settings')['manage_survey']),
        );
      }

      $surveys_table[$id]['operations']['#links']['edit'] = array(
        'title' => t('Edit'),
        'url'   => Url::fromRoute('entity.block.edit_form',
          array("block" => $id)),
      );
    }

    return $surveys_table;
  }

}
