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
   * @var Logger $networkLogger
   */
  protected static null|self $instance = null;
  protected Engine $engine;
  protected Logger $errorLogger;
  protected Logger $networkLogger;

  protected function __construct()
  {
    $this->engine = new Engine();
    $this->errorLogger = new Logger('error');
    $this->networkLogger = new Logger('network');
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
      $this->errorLogger->write($e->getMessage());
      die();
    }

    $this->statistics();
  }

  protected function statistics(): void
  {
    $info = [];

    $info['REQUEST_METHOD'] = 'unknown';
    if (array_key_exists('REQUEST_METHOD', $_SERVER))
      $info['REQUEST_METHOD'] = $_SERVER['REQUEST_METHOD'];

    $info['REQUEST_URI'] = 'unknown';
    if (array_key_exists('REQUEST_URI', $_SERVER))
      $info['REQUEST_URI'] = $_SERVER['REQUEST_URI'];

    $info['HTTP_USER_AGENT'] = 'unknown';
    if (array_key_exists('HTTP_USER_AGENT', $_SERVER))
      $info['HTTP_USER_AGENT'] = $_SERVER['HTTP_USER_AGENT'];

    $info['REMOTE_ADDR'] = 'unknown';
    if (array_key_exists('REMOTE_ADDR', $_SERVER))
      $info['REMOTE_ADDR'] = $_SERVER['REMOTE_ADDR'];

    $this->networkLogger->write("[{$info['REQUEST_METHOD']} - {$info['REQUEST_URI']}] - {$info['REMOTE_ADDR']} ({$info['HTTP_USER_AGENT']})");
  }
}
