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

  protected const CORPUS_DATA_PATH = 'corpus/corpus.csv';

  /**
   * @param Engine $template
   * @return string
   */
  public function appAction(Engine $template): string
  {

    $links = [];
    $corpus = $this->parseCorpus();

    for ($i = 0; $i < 10; $i++) {
      $idx = random_int(0, 1000);
      $links[] = $corpus[$idx];
    }

    $html = $template->render('idx.template.php', [
      'title' => 'SpiderSnare',
      'description' => 'Simple, a trap for spiders and crawlers.',
      'author' => 'Yami-no-karuro',
      'links' => $links
    ]);

    return $html;
  }

  /**
   * @return array
   */
  protected function parseCorpus(): array
  {
    $corpusPath = getProjectRoot() . self::CORPUS_DATA_PATH;
    $reader = new Reader($corpusPath);

    $rows = [];
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
