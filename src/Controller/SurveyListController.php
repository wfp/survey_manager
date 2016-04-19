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
   * Survey list page.
   *
   * @return string
   *   Survey HTML table.
   */
  public function surveyListPage() {

    $button_class = 'button button-action button--primary button--small';
    $route = 'block.admin_add';

    $actions = \Drupal::theme()->render('item_list', [
      'items' => [
        $this->l(t('Add embed survey'), Url::fromRoute($route, [
          'plugin_id' => 'survey-embed',
        ], [
          'attributes' => [
            'class' => $button_class,
          ]
        ])),
        $this->l(t('Add HTML survey'), Url::fromRoute($route, [
          'plugin_id' => 'survey-html',
        ], [
          'attributes' => [
            'class' => $button_class,
          ]
        ])),
      ],
      'attributes' => ['class' => 'action-links'],
    ]);

    $surveys_table = [
      '#type'   => 'table',
      '#prefix' => $actions,
      '#header' => [
        t('Name'),
        t('Sections'),
        t('Type'),
        t('Manage'),
      ],
      '#empty' => t('There are no surveys added.'),
    ];

    $embed_surveys = _survey_manager_get_surveys('survey-embed');
    $html_surveys = _survey_manager_get_surveys('survey-html');

    $surveys = array_merge($embed_surveys, $html_surveys);

    $manager = \Drupal::service('plugin.manager.block');
    $definitions = $manager->getDefinitions();

    foreach ($surveys as $id => $survey) {
      $plugin_id = $survey->get('settings')['id'];

      $surveys_table[$id]['name'] = array(
        '#plain_text' => $survey->get('settings')['label'],
      );

      $sections = '';
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

      $surveys_table[$id]['type'] = [
        '#plain_text' => $definitions[$plugin_id]['admin_label']->getUntranslatedString(),
      ];

      $surveys_table[$id]['operations'] = [
        '#type'  => 'operations',
        '#links' => [],
      ];

      $surveys_table[$id]['operations']['#links']['edit'] = array(
        'title' => t('Edit'),
        'url' => Url::fromRoute('entity.block.edit_form',
          array("block" => $id)),
      );

      $surveys_table[$id]['operations']['#links']['delete'] = array(
        'title' => t('Delete'),
        'url' => Url::fromRoute('entity.block.delete_form',
          array("block" => $id)),
      );

      if (!empty($survey->get('settings')['manage_survey'])) {
        $surveys_table[$id]['operations']['#links']['manage'] = array(
          'title' => t('Manage'),
          'url' => Url::fromUri($survey->get('settings')['manage_survey']),
        );
      }
    }

    return $surveys_table;
  }

}
