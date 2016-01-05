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
      '#empty'  => t('There are no surveys yet. You have to add HTML or Embed block.'),
    );

    $embed_surveys = _survey_manager_get_surveys('survey_embed_code_block');
    $html_surveys  = _survey_manager_get_surveys('survey_htmlblock');

    $surveys = array_merge($embed_surveys, $html_surveys);

    foreach ($surveys as $id => $survey) {
      $surveys_table[$id]['name'] = array(
        '#plain_text' => $survey->get('settings')['label'],
      );

      $surveys_table[$id]['sections'] = array(
        '#plain_text' => "Section Name",
      );

      $surveys_table[$id]['type'] = array(
        '#plain_text' => "Type of the survey",
      );

      $surveys_table[$id]['manage'] = array(
        '#type'  => 'operations',
        '#links' => array(),
      );

      if (!empty($survey->get('settings')['manage_survey'])) {
        $surveys_table[$id]['manage']['#links']['manage'] = array(
          'title' => t('Manage'),
          'url'   => $survey->get('settings')['manage_survey'],
        );
      }

      $surveys_table[$id]['manage']['#links']['edit'] = array(
        'title' => t('Edit'),
        'url'   => Url::fromRoute('block.admin_display'),
      );
    }

    return $surveys_table;
  }

}
