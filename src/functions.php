<?php

if (!defined('NO_DIRECT_ACCESS')) {
  header('HTTP/1.1 403 Forbidden');
  die();
}

/**
 * @return string
 */
function getProjectRoot(): string
{
  $wdir = getcwd();
  if (str_contains($wdir, 'public'))
    return $wdir . '/../';

  return $wdir . '/';
}
