<?php

/**
 * @file
 * Contains \Drupal\survey_manager\Plugin\Filter\FilterSurvey.
 */

namespace Drupal\survey_manager\Plugin\Filter;

use Drupal\filter\FilterProcessResult;
use Drupal\filter\Plugin\FilterBase;
use Drupal\block\Entity\Block;

/**
 * This filter replaces token [survey:id] the content of survey.
 *
 * @Filter(
 *   id = "filter_survey",
 *   title = @Translation("Survey Filter"),
 *   description = @Translation("Display an HTML survey by block id. (e.g.
 *   [survey:bid])"), type =
 *   Drupal\filter\Plugin\FilterInterface::TYPE_MARKUP_LANGUAGE,
 * )
 */
class FilterSurvey extends FilterBase {

  /**
   * {@inheritdoc}
   */
  public function process($text, $langcode) {
    $new_text = $text;
    $filter_result = new FilterProcessResult($text);

    preg_match('/\[survey\:.+\]/', $text, $result);
    $token = $result[0];
    $start = strpos($token, ':') + 1;
    $length = strpos($token, ']') - $start;
    $id = substr($token, $start, $length);
    $block  = Block::load($id);
    if ($block) {
      $replace  = $block->get('settings')['html'];
      $new_text = str_replace($token, $replace, $text);
      $filter_result->setProcessedText($new_text);
      $filter_result->setCacheTags($block->getCacheTags());
    }

    return $filter_result;
  }

}
