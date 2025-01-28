<?php

namespace App\Controller;

use App\Module\Reader;
use App\Template\Engine;

if (!defined('NO_DIRECT_ACCESS')) {
  header('HTTP/1.1 403 Forbidden');
  die();
}

class AppController
{

  /**
   * @param Engine $template
   * @return void
   */
  public function appAction(Engine $template): void
  {
    $links = [];
    $corpus = $this->parseCorpus();

    for ($i = 0; $i < 10; $i++) {
      $idx = random_int(0, 1000);
      $links[] = $corpus[$idx];
    }

    $content = $template->render('app.template.php', [
      'title' => 'Spider-Snare',
      'description' => 'A simple loop-hole for web-spiders and crawlers.',
      'author' => 'Yami-no-karuro',
      'links' => $links
    ]);

    $this->sendHeaders($content);
    $this->streamContent($content);
  }

  /**
   * @param string $response
   * @return void
   */
  protected function sendHeaders(string &$response): void
  {
    header('HTTP/1.1 200 OK');
    header('Content-Type: text/html');
    header('Content-Length: ' . strlen($response));
  }

  /**
   * @param string $response
   * @return void
   */
  protected function streamContent(string &$response): void
  {
    ob_implicit_flush(true);
    ob_end_flush();

    $splitted = str_split($response);
    foreach ($splitted as $byte) {
      echo $byte;

      flush();
      usleep(RESPONSE_BYTE_DELAY);
    }

    flush();
  }

  /**
   * @return array
   */
  protected function parseCorpus(): array
  {
    $rows = [];
    $corpusPath = getProjectRoot() . CORPUS_DATA_PATH;
    $reader = new Reader($corpusPath);

    $keys = [];
    foreach ($reader->getRows() as $index => $row) {
      if ($index === 0) {
        $keys = array_map(fn($el) => trim($el), $row);
        continue;
      }

      $rows[$index] = array_combine($keys, $row);
    }

    return $rows;
  }
}
