<?php

namespace App\Module;

class Logger
{

  protected string $domain;
  protected string $path;

  /**
   * @param string $domain
   */
  public function __construct(string $domain)
  {
    $this->domain = $domain;
    $this->path = getProjectRoot() . 'var/logs/' . $this->domain . '.log.txt';
  }

  /**
   * @param string $log
   * @return void
   */
  public function write(string $log): void
  {
    $log = '[' . date('Y-m-d h:m:s') . '] - ' . $log . PHP_EOL;
    file_put_contents($this->path, $log, FILE_APPEND);
  }
}
