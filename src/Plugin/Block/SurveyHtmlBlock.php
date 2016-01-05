<?php

/**
 * @file
 * Contains \Drupal\survey_manager\Plugin\Block\SurveyHtmlBlock.
 */

namespace Drupal\survey_manager\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'Survey HtmlBlock' block.
 *
 * @Block(
 *  id = "survey_htmlblock",
 *  admin_label = @Translation("Survey HTMLBlock"),
 * )
 */
class SurveyHtmlBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {

    $manage_survey_default_value = "";
    if (isset($this->configuration['manage_survey'])) {
      $manage_survey_default_value = $this->configuration['manage_survey'];
    }

    $form['manage_survey'] = array(
      '#type'          => 'textfield',
      '#title'         => $this->t('Manage survey'),
      '#description'   => $this->t('Optional URL to third party survey tool.'),
      '#default_value' => $manage_survey_default_value,
      '#weight'        => '1',
    );

    $html_default_value = "";
    if (isset($this->configuration['html'])) {
      $html_default_value = $this->configuration['html'];
    }

    $form['html'] = array(
      '#type'          => 'textarea',
      '#title'         => $this->t('HTML Code'),
      '#description'   => $this->t('HTML code of the survey.'),
      '#default_value' => $html_default_value,
      '#weight'        => '1',
    );

    return $form;
  }


  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['manage_survey'] = $form_state->getValue('manage_survey');
    $this->configuration['html']          = $form_state->getValue('html');
  }


  /**
   * {@inheritdoc}
   */
  public function build() {
    $build                                     = [];
    $build['survey_htmlblock_html']['#markup'] = '<div>' . $this->configuration['html'] . '</div>';

    return $build;
  }

}
