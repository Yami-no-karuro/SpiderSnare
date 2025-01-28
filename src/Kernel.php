<?php

namespace App;

use App\Controller\AppController;
use App\Template\Engine;

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
   */
  protected static null|self $instance = null;
  protected Engine $engine;

  protected function __construct()
  {
    $this->engine = new Engine();
  }

  /**
   * @return void
   */
  public function run(): void
  {
    $controller = new AppController();
    $controller->appAction($this->engine);
  }
}
