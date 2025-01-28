<?php

namespace App;

use App\Controller\AppController;
use App\Module\Logger;
use App\Template\Engine;
use Exception;

if (!defined('NO_DIRECT_ACCESS')) {
  header('HTTP/1.1 403 Forbidden');
  die();
}

class Kernel
{

  /**
   * @return self
   */
  public static function bootstrap(): self
  {
    if (self::$instance == null)
      self::$instance = new self();

    return self::$instance;
  }

  /**
   * @var null|self $instance
   * @var Engine $engine
   * @var Logger $logger
   */
  protected static null|self $instance = null;
  protected Engine $engine;
  protected Logger $logger;

  protected function __construct()
  {
    $this->engine = new Engine();
    $this->logger = new Logger('error');
  }

  /**
   * @return void
   */
  public function run(): void
  {
    try {
      $controller = new AppController();
      $controller->appAction($this->engine);
    } catch (Exception $e) {
      $this->logger->write($e->getMessage());
    }
  }
}
