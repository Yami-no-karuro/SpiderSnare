<?php

namespace App\Cache;

if (!defined('NO_DIRECT_ACCESS')) {
  header('HTTP/1.1 403 Forbidden');
  die();
}

class Agent
{

  protected const TTL = 900;

  /**
   * @param string $key
   * @param mixed $value
   * @return bool
   */
  public static function set(string $key, mixed $value): bool
  {
    return apcu_store($key, $value, self::TTL);
  }

  /**
   * @param string $key
   * @return mixed
   */
  public static function get(string $key): mixed
  {
    return apcu_fetch($key) ?: null;
  }

  /**
   * @param string $key
   * @return bool
   */
  public static function has(string $key): bool
  {
    return apcu_exists($key);
  }

  /**
   * @param string $key
   * @return bool
   */
  public static function delete(string $key): bool
  {
    return apcu_delete($key);
  }

  /**
   * @return bool
   */
  public static function clear(): bool
  {
    return apcu_clear_cache();
  }
}
