<?php

/**
 * @file
 * Contains \Drupal\survey_manager\Plugin\Block\SurveyEmbedCodeBlock.
 */

namespace Drupal\survey_manager\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Provides a 'SurveyEmbedCodeBlock' block.
 *
 * @Block(
 *  id = "survey-embed",
 *  admin_label = @Translation("Survey embed"),
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

    $form['#attributes'] = ['class' => ['block-survey-form']];

    $form['manage_survey_embed'] = [
      '#type' => 'url',
      '#title' => $this->t('Manage survey embed'),
      '#description' => $this->t('Optional URL to third party survey embed tool.'),
      '#default_value' => $manage_survay_default_value,
      '#weight' => 20,
    ];

    $embed_code_default_value = '';
    if (isset($this->configuration['embed_code'])) {
      $embed_code_default_value = $this->configuration['embed_code'];
    }

    $form['embed_code'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Embed code'),
      '#description' => $this->t('Embed code of the survey.'),
      '#default_value' => $embed_code_default_value,
      '#weight' => 10,
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['manage_survey'] = $form_state->getValue('manage_survey_embed');
    $this->configuration['embed_code'] = $form_state->getValue('embed_code');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    $build['survey_embed_code_block_manage_survey']['#markup'] = '';
    $build['survey_embed_code_block_embed_code']['#markup'] = '';

    return $build;
  }

}
