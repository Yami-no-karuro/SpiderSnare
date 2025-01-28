<?php

if (!defined('NO_DIRECT_ACCESS')) {
  header('HTTP/1.1 403 Forbidden');
  die();
}

const DEFAULT_TIMEZONE = 'Europe/Rome';

const MINUTE_IN_SECONDS = 60;
const HOUR_IN_SECONDS = 3600;
const DAY_IN_SECONDS = 86400;
const WEEK_IN_SECONDS = 604800;
