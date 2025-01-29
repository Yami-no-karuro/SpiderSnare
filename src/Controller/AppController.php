<?php

namespace App\Controller;

use App\Module\Reader;
use App\Template\Engine;

if (!defined('NO_DIRECT_ACCESS')) {
  header('HTTP/1.1 403 Forbidden');
  die();
}

class AppController extends MasterController
{

  /**
   * @param Engine $template
   * @return void
   */
  public function appAction(Engine $template): void
  {
    $links = $this->getRandomLinks();
    $content = $template->render('app.template.php', [
      'title' => 'Spider-Snare',
      'description' => 'A simple loop-hole for web-spiders and crawlers.',
      'author' => 'Yami-no-karuro',
      'links' => $links
    ]);

    $this->headers(
      MasterController::HTTP_OK,
      MasterController::CONTENT_TYPE_HTML
    );

    $this->content($content);
  }

  /**
   * @return array
   */
  protected function getRandomLinks(): array
  {
    $links = [];
    $corpus = $this->parseCorpus();

    for ($i = 0; $i < 10; $i++) {
      $idx = random_int(0, 1000);
      $links[] = $corpus[$idx];
    }

    return $links;
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
