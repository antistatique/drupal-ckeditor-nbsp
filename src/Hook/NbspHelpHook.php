<?php

declare(strict_types=1);

namespace Drupal\nbsp\Hook;

use Drupal\Component\Plugin\PluginManagerInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Extension\ModuleExtensionList;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Hook\Attribute\Hook;
use Drupal\Core\Routing\RouteMatchInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

/**
 * Hook implementation of hook_help() for the NBSP module.
 */
#[Hook('help')]
final class NbspHelpHook {

  /**
   * Class constructor.
   */
  public function __construct(
    protected ModuleHandlerInterface $moduleHandler,
    protected ModuleExtensionList $moduleExtensionList,
    protected ConfigFactoryInterface $configFactory,
    #[Autowire(service: 'plugin.manager.filter')]
    protected PluginManagerInterface $filterManager,
  ) {
  }

  /**
   * Implements hook_help().
   */
  public function __invoke(string $route_name, RouteMatchInterface $route_match): ?string {
    if ($route_name !== 'help.page.nbsp') {
      return NULL;
    }

    $text = (string) file_get_contents($this->moduleExtensionList->getPath('nbsp') . '/README.md');
    if (!$this->moduleHandler->moduleExists('markdown')) {
      return '<pre>' . $text . '</pre>';
    }

    // Use the Markdown filter to render the README.
    $settings = $this->configFactory->get('markdown.settings')->getRawData();
    $filter = $this->filterManager->createInstance('markdown', ['settings' => $settings]);

    return $filter->process($text, 'en')->getProcessedText();
  }

}
