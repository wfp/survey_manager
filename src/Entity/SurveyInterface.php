<?php

/**
 * @file
 * Contains \Drupal\survey_manager\Entity\SurveyInterface.
 */

namespace Drupal\survey_manager\Entity;

use Drupal\Core\Config\Entity\ConfigEntityInterface;

/**
 * Provides an interface for survey.
 */
interface SurveyInterface extends ConfigEntityInterface {

  public function getCode();

  public function getType();

  public function getVisibility();

  public function accessable();

}