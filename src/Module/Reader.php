<?php

namespace App\Module;

use Generator;

class Reader
{

  protected mixed $handle;
  protected string $delimiter;

  /**
   * @param mixed $file
   * @param string $delimeter
   */
  public function __construct(mixed $file, string $delimiter = ',')
  {
    $this->handle = $file;
    if (!is_resource($file))
      $this->handle = fopen($file, 'r');

    $this->delimiter = $delimiter;
  }

  public function __destruct()
  {
    if (is_resource($this->handle))
      fclose($this->handle);
  }

  /** 
   * @return Generator 
   */
  public function getRows(): Generator
  {
    while (!feof($this->handle)) {
      $row = fgetcsv($this->handle, 0, $this->delimiter);
      if ($row !== false)
        yield $row;
    }
  }
}
