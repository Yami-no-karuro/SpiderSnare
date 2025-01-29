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

  protected const RESPONSE_BYTE_DELAY = 2500;

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
   * @param bool $streamed
   * @return void
   */
  protected function content(string &$response, bool $streamed = false): void
  {
    header('Content-Length: ' . strlen($response));
    if (!$streamed) {
      echo $response;
      return;
    }

    header('Connection: keep-alive');
    foreach (str_split($response) as $byte) {
      echo $byte;

      flush();
      usleep(self::RESPONSE_BYTE_DELAY);
    }
  }
}
