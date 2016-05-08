<?php

/**
 * @file
 * Contains \Drupal\survey_manager\Plugin\Filter\FilterSurvey.
 */

namespace Drupal\survey_manager\Plugin\Filter;

use Drupal\filter\FilterProcessResult;
use Drupal\filter\Plugin\FilterBase;
use Drupal\survey_manager\Entity\Survey;

/**
 * This filter replaces token [survey:id] with the content of survey.
 *
 * @Filter(
 *   id = "filter_survey",
 *   title = @Translation("Replace survey token with survey HTML"),
 *   description = @Translation("Display HTML survey using token - [survey:id]"),
 *   type = Drupal\filter\Plugin\FilterInterface::TYPE_MARKUP_LANGUAGE,
 * )
 */
class FilterSurvey extends FilterBase {

  /**
   * {@inheritdoc}
   */
  public function process($text, $langcode) {
    $result = new FilterProcessResult($text);
    if (preg_match_all('/\[survey\:(.+)\]/', $text, $match)) {
      if (isset($match[1]) && is_array($match[1])) {
        foreach ($match[1] as $sid) {
          $entity = Survey::load($sid);
          if ($entity->accessable()) {
            $replacement = $entity->getCode();
            $text = str_replace($match[0], $replacement, $text);
            $result->setProcessedText($text);
            $result->setCacheTags($entity->getCacheTags());
          }
        }
      }
    }

    return $result;
  }

}
