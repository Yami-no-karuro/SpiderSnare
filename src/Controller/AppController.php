<?php

namespace App\Controller;

use App\Cache\Agent;
use App\Module\Reader;
use App\Template\Engine;

if (!defined('NO_DIRECT_ACCESS')) {
  header('HTTP/1.1 403 Forbidden');
  die();
}

class AppController extends MasterController
{

  protected const CORPUS_DATA_PATH = 'corpus/corpus.csv';
  protected const APP_TITLE = 'Spider-Snare';
  protected const APP_DESCRIPTION = 'A simple loop-hole for web-spiders and crawlers.';
  protected const APP_AUTHOR = '#zerotrace';

  /**
   * @param Engine $template
   * @return void
   */
  public function appAction(Engine $template): void
  {
    $links = $this->getRandomLinks();
    $content = $template->render('app.template.php', [
      'title' => self::APP_TITLE,
      'description' => self::APP_DESCRIPTION,
      'author' => self::APP_AUTHOR,
      'links' => $links
    ]);

    $this->headers(
      MasterController::HTTP_OK,
      MasterController::CONTENT_TYPE_HTML
    );

    $this->content($content, true);
  }

  /**
   * @return array
   */
  protected function getRandomLinks(): array
  {
    $links = [];
    if (null === ($corpus = Agent::get('corpus'))) {
      $corpus = $this->parseCorpus();
      Agent::set('corpus', $corpus);
    }

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
    $corpusPath = getProjectRoot() . self::CORPUS_DATA_PATH;
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
