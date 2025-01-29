<?php

namespace App\Module;

class Logger
{

  protected const MAX_SIZE = 258_291;
  protected const MAX_FILES = 5;

  protected string $domain;
  protected string $path;

  /**
   * @param string $domain
   */
  public function __construct(string $domain)
  {
    $this->domain = $domain;
    $this->path = getProjectRoot() . 'var/log/' . $this->domain . '.log.txt';
  }

  /**
   * @param string $log
   * @return void
   */
  public function write(string $log): void
  {
    if (file_exists($this->path) && filesize($this->path) >= self::MAX_SIZE)
      $this->rotateLogs();

    $log = '[' . date('Y-m-d h:m:s') . '] - ' . $log . PHP_EOL;
    file_put_contents($this->path, $log, FILE_APPEND);
  }

  /**
   * @return void
   */
  protected function rotateLogs(): void
  {
    $oldest = $this->path . '.' . self::MAX_FILES;
    if (file_exists($oldest))
      unlink($oldest);

    for ($i = self::MAX_FILES - 1; $i >= 1; $i--) {
      $old = $this->path . '.' . $i;
      $new = $this->path . '.' . ($i + 1);

      if (file_exists($old))
        rename($old, $new);
    }

    rename($this->path, $this->path . '.1');
  }
}
