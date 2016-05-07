<?php

namespace Drupal\survey_manager;

use Drupal\Core\Config\Entity\ConfigEntityListBuilder;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Component\Utility\Html;
use Drupal\Component\Render\FormattableMarkup;

class SurveyListBuilder extends ConfigEntityListBuilder {

  protected function visibility(EntityInterface $entity) {
    $visibility = $entity->getVisibility();
    $output = '';

    $content_types = array_filter($visibility['content_types']);
    $user_roles = array_filter($visibility['user_roles']);
    $pages = $visibility['pages'];

    if ($content_types) {
      $output .= sprintf('<strong>content types</strong>: %s<br/>', implode(', ', $content_types));
    }

    if ($user_roles) {
      $output .= sprintf('<strong>roles</strong>: %s<br/>', implode(', ', $user_roles));
    }

    if ($pages) {
      $output .= '<strong>pages</strong>:' . ' ' . Html::escape($pages);
    }

    return new FormattableMarkup($output, []);
  }

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['name'] = t('Name');
    $header['visibility'] = t('Visibility');
    $header['type'] = t('Type');

    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    $row['name'] = $entity->label();
    $row['visibility'] = $this->visibility($entity);
    $row['type'] = $entity->getType();

    return $row + parent::buildRow($entity);
  }

}
