<?php

/**
 * @file
 * Contains \Drupal\survey_manager\Plugin\Block\HTMLBlock.
 */

namespace Drupal\survey_manager\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'HTMLBlock' block.
 *
 * @Block(
 *  id = "htmlblock",
 *  admin_label = @Translation("Htmlblock"),
 * )
 */
class HTMLBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $active = '';
    if (isset($this->configuration['active'])) {
      $this->configuration['active'];
    }

    $form['active'] = array(
      '#type'          => 'checkbox',
      '#title'         => $this->t('Active'),
      '#description'   => $this->t('Is the survey active?'),
      '#default_value' => $active,
      '#weight'        => '2',
    );

    return $form;
  }


  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['active'] = $form_state->getValue('active');
  }


  /**
   * {@inheritdoc}
   */
  public function build() {
    $build                                = [];
    $build['htmlblock_active']['#markup'] = '<p>' . $this->configuration['active'] . '</p>';

    return $build;
  }

}
