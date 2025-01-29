<?php

namespace App\Controller;

if (!defined('NO_DIRECT_ACCESS')) {
  header('HTTP/1.1 403 Forbidden');
  die();
}

class MasterController
{

  public const HTTP_OK = '200 OK';
  public const HTTP_CREATED = '201 CREATED';
  public const HTTP_BAD_REQUEST = '400 BAD REQUEST';
  public const HTTP_UNAUTHORIZED = '401 UNAUTHORIZED';
  public const HTTP_FORBIDDEN = '403 FORBIDDEN';
  public const HTTP_NOT_FOUND = '404 NOT FOUND';
  public const HTTP_INTERNAL_SERVER_ERROR = '500 INTERNAL SERVER ERROR';

  public const CONTENT_TYPE_TEXT = 'text/plain';
  public const CONTENT_TYPE_HTML = 'text/html';
  public const CONTENT_TYPE_JSON = 'application/json';
  public const CONTENT_TYPE_CSV = 'text/csv';

  /**
   * @param string $status
   * @param string $contentType
   * @return void
   */
  protected function headers(
    string $status = self::HTTP_OK,
    string $contentType = self::CONTENT_TYPE_TEXT
  ): void {
    header("HTTP/1.1 {$status}");
    header("Content-Type: {$contentType}");
    header('Connection: keep-alive');
  }

  /**
   * @param string $response
   * @return void
   */
  protected function content(string &$response): void
  {
    $splitted = str_split($response);
    foreach ($splitted as $byte) {
      echo $byte;

      flush();
      usleep(RESPONSE_BYTE_DELAY);
    }
  }
}
