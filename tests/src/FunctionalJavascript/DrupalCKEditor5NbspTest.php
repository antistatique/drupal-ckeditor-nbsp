<?php

namespace Drupal\Tests\nbsp\FunctionalJavascript;

use Drupal\editor\Entity\Editor;
use Drupal\filter\Entity\FilterFormat;
use Drupal\FunctionalJavascriptTests\WebDriverTestBase;
use Drupal\Tests\ckeditor5\Traits\CKEditor5TestTrait;

/**
 * Ensure the NBSP CKeditor 5 dialog works.
 *
 * @group nbsp
 * @group nbsp_functional
 */
class DrupalCKEditor5NbspTest extends WebDriverTestBase {

  use CKEditor5TestTrait;

  /**
   * {@inheritdoc}
   */
  protected static $modules = [
    'filter',
    'node',
    'ckeditor5',
    'nbsp',
  ];

  /**
   * We use the minimal profile because we want to test local action links.
   *
   * @var string
   */
  protected $profile = 'minimal';

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'starterkit_theme';

  /**
   * A user with the 'administer filters' permission.
   *
   * @var \Drupal\user\UserInterface
   */
  protected $adminUser;

  /**
   * Defines a CKEditor using the "Full HTML" filter.
   *
   * @var \Drupal\editor\EditorInterface
   */
  protected $editor;

  /**
   * Defines a "Full HTML" filter format.
   *
   * @var \Drupal\filter\FilterFormatInterface
   */
  protected $editorFilterFormat;

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();

    // Create text format.
    $this->editorFilterFormat = FilterFormat::create([
      'format' => 'full_html',
      'name' => 'Full HTML',
      'weight' => 0,
      'filters' => ['nbsp_cleaner_filter' => ['status' => TRUE]],
    ]);
    $this->editorFilterFormat->save();

    $this->editor = Editor::create([
      'format' => 'full_html',
      'editor' => 'ckeditor5',
    ]);
    $settings = [
      'toolbar' => [
        'items' => [
          'sourceEditing',
          'bold',
          'italic',
          'nbsp',
        ],
      ],
      'plugins' => [
        'ckeditor5_sourceEditing' => [
          'allowed_tags' => [],
        ],
      ],
    ];
    $this->editor->setSettings($settings);
    $this->editor->save();

    // Create a node type for testing.
    $this->drupalCreateContentType(['type' => 'page']);

    // Create a user for tests.
    $this->adminUser = $this->drupalCreateUser([
      'administer nodes',
      'create page content',
      'use text format full_html',
    ]);

    $this->drupalLogin($this->adminUser);
  }

  /**
   * Ensure the CKeditor still works when NBSP plugin is enabled.
   */
  public function testEditorWorksWhenNbspEnabled() {
    $this->drupalGet('node/add/page');
    $this->waitForEditor();
    $assert_session = $this->assertSession();

    // Ensure CKeditor works properly.
    $this->assertNotEmpty($assert_session->waitForElementVisible('css', '.ck-editor__editable', 1000));

    // Ensure the button NBSP is visible.
    $this->assertEditorButtonEnabled('Insert non-breaking space');
  }

  /**
   * Ensure the CKeditor still works when NBSP plugin is not enabled.
   */
  public function testEditorWorksWhenNbspNotEnabled() {
    // Add a default class in the settings.
    $settings = [
      'toolbar' => [
        'items' => [
          'bold',
          'italic',
        ],
      ],
      'plugins' => [],
    ];
    $this->editor->setSettings($settings);
    $this->editor->save();

    $this->drupalGet('node/add/page');

    $this->waitForEditor();
    $assert_session = $this->assertSession();

    // Ensure CKeditor works properly.
    $this->assertNotEmpty($assert_session->waitForElementVisible('css', '.ck-editor__editable', 1000));

    // Ensure the button NBSP is not visible.
    $this->assertNull($assert_session->waitForElementVisible('xpath', "//button[span[text()='Insert non-breaking space']]"));
  }

  /**
   * Tests using Drupal Nbsp button to add non-breaking space into CKEditor.
   */
  public function testButton() {
    $this->drupalGet('node/add/page');
    $this->waitForEditor();
    $assert_session = $this->assertSession();
    $editor = $assert_session->waitForElementVisible('css', '.ck-editor__editable', 1000);
    // You can't add the <nbsp> tag alone, it needs some text.
    $editor->setValue('text');
    $this->pressEditorButton('Insert non-breaking space');
    $xpath = new \DOMXPath($this->getEditorDataAsDom());
    $nbsp = $xpath->query('//nbsp')[0];
    $this->assertEquals(" ", $nbsp->firstChild->nodeValue);
  }

}
