<?php

namespace Drupal\Tests\nbsp\Kernel;

use Drupal\filter\FilterPluginCollection;
use Drupal\filter\FilterProcessResult;
use Drupal\KernelTests\KernelTestBase;

/**
 * @coversDefaultClass \Drupal\nbsp\Plugin\Filter\NbspCleanerFilter
 *
 * @group nbsp
 */
class NbspCleanerFilterTest extends KernelTestBase {

  /**
   * Modules to enable.
   *
   * @var array
   */
  protected static $modules = ['system', 'filter', 'nbsp'];

  /**
   * Collection of CKeditor Plugin filters.
   *
   * @var \Drupal\filter\Plugin\FilterInterface[]
   */
  protected $filters;

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();
    $this->installConfig(['system']);

    $manager = $this->container->get('plugin.manager.filter');
    $bag = new FilterPluginCollection($manager, []);
    $this->filters = $bag->getAll();
  }

  /**
   * @covers ::process
   *
   * @dataProvider providerTexts
   */
  public function testCleanerFilter($input, $expected) {
    $filter = $this->filters['nbsp_cleaner_filter'];

    /** @var \Drupal\filter\FilterProcessResult $result */
    $result = $filter->process($input, 'und');
    $this->assertInstanceOf(FilterProcessResult::class, $result);
    $this->assertEquals($expected, $result->getProcessedText());
  }

  /**
   * Provides texts to check and expected results.
   */
  public function providerTexts() {
    return [
      ['', ''],
      ['<p>Maecenas cursus posuere</p>', '<p>Maecenas cursus posuere</p>'],
      [
        '<p>Maecenas<nbsp>&nbsp;</nbsp>cursus posuere</p>',
        '<p>Maecenas cursus posuere</p>',
      ],
      [
        '<p>Maecenas<nbsp>&nbsp;</nbsp>cursus<nbsp>&nbsp;</nbsp>posuere</p>',
        '<p>Maecenas cursus posuere</p>',
      ],
      [
        '<p>Maecenas<div class="nbsp">&nbsp;</div>cursus posuere</p>',
        '<p>Maecenas</p><div class="nbsp"> </div>cursus posuere',
      ],
      [
        '<p>Maecenas<span>&nbsp;</span>cursus posuere</p>',
        '<p>Maecenas<span> </span>cursus posuere</p>',
      ],
    ];
  }

}
