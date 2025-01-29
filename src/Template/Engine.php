<?php

namespace App\Template;

use Exception;

if (!defined('NO_DIRECT_ACCESS')) {
  header('HTTP/1.1 403 Forbidden');
  die();
}

class Engine
{

  protected string $templatePath;

  /**
   * @param null|string $templatePath
   */
  public function __construct(?string $templatePath = null)
  {
    if (null === $templatePath)
      $templatePath = getProjectRoot() . 'templates';

    $this->templatePath = rtrim($templatePath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
  }

  /**
   * @param string $templateFile
   * @param array $variables
   * @return string
   */
  public function render(string $templateFile, array $variables = []): string
  {
    $templateFullPath = $this->templatePath . $templateFile;

    extract($variables);
    ob_start();

    try {
      include $templateFullPath;
    } catch (Exception $e) {
      ob_end_clean();
      throw $e;
    }

    return ob_get_clean();
  }
}
