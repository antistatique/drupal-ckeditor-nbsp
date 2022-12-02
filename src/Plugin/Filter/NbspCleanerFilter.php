<?php

declare(strict_types=1);

namespace Drupal\nbsp\Plugin\Filter;

use Drupal\Component\Utility\Html;
use Drupal\filter\FilterProcessResult;
use Drupal\filter\Plugin\FilterBase;

/**
 * NBSP Cleaner Filter class. Implements process() method only.
 *
 * @Filter(
 *   id = "nbsp_cleaner_filter",
 *   title = @Translation("Cleanup NBSP markup"),
 *   description = @Translation("Replaces <code>&lt;nbsp&gt;&lt;/nbsp&gt;</code> tag with non-breaking space."),
 *   type = Drupal\filter\Plugin\FilterInterface::TYPE_TRANSFORM_IRREVERSIBLE,
 * )
 */
class NbspCleanerFilter extends FilterBase {

  /**
   * {@inheritdoc}
   */
  public function process($text, $langcode) {
    $filtered = $this->swapNbspHtml($text);
    if ($filtered) {
      $result = new FilterProcessResult($filtered);
    }
    else {
      $result = new FilterProcessResult($text);
    }

    return $result;
  }

  /**
   * Replace <span class="nbsp"> and <nbsp></nbsp> tags with respected HTML.
   *
   * The previous tag (span.nbsp) is still on the filter to keep
   * compatibility with previous content created.
   *
   * @param string $text
   *   The HTML string to replace <span class="nbsp"> and <nbsp></nbsp> tags.
   *
   * @return string
   *   The HTML with all the <span class="nbsp"> and <nbsp></nbsp>
   *   tags replaced with their respected html.
   */
  protected function swapNbspHtml($text) {
    $document = Html::load($text);
    $xpath = new \DOMXPath($document);

    foreach ($xpath->query('//span[@class="nbsp"]') as $node) {
      if (!empty($node) && !empty($node->nodeValue)) {
        // PHP DOM removing the tag (not content)
        $node->parentNode->replaceChild(new \DOMText($node->nodeValue), $node);
      }
    }
    foreach ($xpath->query('//nbsp') as $node) {
      if (!empty($node) && !empty($node->nodeValue)) {
        // PHP DOM removing the tag (not content)
        $node->parentNode->replaceChild(new \DOMText($node->nodeValue), $node);
      }
    }
    return Html::serialize($document);

  }

}
