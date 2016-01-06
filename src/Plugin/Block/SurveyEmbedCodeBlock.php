<?php

/**
 * @file
 * Contains \Drupal\survey_manager\Plugin\Block\SurveyEmbedCodeBlock.
 */

namespace Drupal\survey_manager\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'SurveyEmbedCodeBlock' block.
 *
 * @Block(
 *  id = "survey_embed_code_block",
 *  admin_label = @Translation("Embed Survey"),
 * )
 */
class SurveyEmbedCodeBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $manage_survay_default_value = '';
    if (isset($this->configuration['manage_survey'])) {
      $manage_survay_default_value = $this->configuration['manage_survey'];
    }

    $form['manage_survey'] = array(
      '#type'          => 'url',
      '#title'         => $this->t('Manage survey'),
      '#description'   => $this->t('Optional URL to third party survey tool.'),
      '#default_value' => $manage_survay_default_value,
      '#weight'        => '1',
    );

    $embed_code_default_value = '';
    if (isset($this->configuration['embed_code'])) {
      $embed_code_default_value = $this->configuration['embed_code'];
    }

    $form['embed_code'] = array(
      '#type'          => 'textarea',
      '#title'         => $this->t('Embed Code'),
      '#description'   => $this->t('Embed code of the survey.'),
      '#default_value' => $embed_code_default_value,
      '#weight'        => '3',
    );

    return $form;
  }


  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['manage_survey'] = $form_state->getValue('manage_survey');
    $this->configuration['embed_code']    = $form_state->getValue('embed_code');
  }


  /**
   * {@inheritdoc}
   */
  public function build() {
    $build                                                     = [];
    $build['survey_embed_code_block_manage_survey']['#markup'] = "";
    $build['survey_embed_code_block_embed_code']['#markup']    = "";

    return $build;
  }

}
