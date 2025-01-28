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

  protected const BYTE_DELAY = 5000;

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
    $response = $controller->appAction($this->engine);

    $this->sendHeaders($response);
    $this->streamResponse($response);
  }

  /**
   * @param string $response
   * @return void
   */
  protected function sendHeaders(string &$response): void
  {
    header('Content-Type: text/html');
    header('Content-Length: ' . strlen($response));
  }

  /**
   * @param string $response
   * @return void
   */
  protected function streamResponse(string &$response): void
  {
    ob_implicit_flush(true);
    ob_end_flush();

    $splitted = str_split($response);
    foreach ($splitted as $byte) {
      echo $byte;

      flush();
      usleep(self::BYTE_DELAY);
    }

    flush();
  }
}
