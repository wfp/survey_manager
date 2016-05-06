<?php

namespace Drupal\survey_manager\Entity;

use Drupal\Core\Config\Entity\ConfigEntityInterface;

interface SurveyInterface extends ConfigEntityInterface {

  public function getCode();

}