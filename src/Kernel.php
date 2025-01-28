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
   * @var Logger $errorLogger
   * @var Logger $infoLogger
   */
  protected static null|self $instance = null;
  protected Engine $engine;
  protected Logger $errorLogger;
  protected Logger $infoLogger;

  protected function __construct()
  {
    $this->engine = new Engine();
    $this->errorLogger = new Logger('error');
    $this->infoLogger = new Logger('info');
  }

  /**
   * @return void
   */
  public function run(): void
  {

    $this->statistics();

    try {
      $controller = new AppController();
      $controller->appAction($this->engine);
    } catch (Exception $e) {
      $this->errorLogger->write($e->getMessage());
    }
  }

  protected function statistics(): void
  {
    $info = [];

    $info['HTTP_USER_AGENT'] = null;
    if (array_key_exists('HTTP_USER_AGENT', $_SERVER))
      $info['HTTP_USER_AGENT'] = $_SERVER['HTTP_USER_AGENT'];

    $info['REMOTE_ADDR'] = null;
    if (array_key_exists('REMOTE_ADDR', $_SERVER))
      $info['REMOTE_ADDR'] = $_SERVER['REMOTE_ADDR'];

    $this->infoLogger->write("IP: {$info['REMOTE_ADDR']}, User Agent: {$info['HTTP_USER_AGENT']}");
  }
}
