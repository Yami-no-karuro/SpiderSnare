<?php

namespace App\Controller;

use App\Template\Engine;

if (!defined('NO_DIRECT_ACCESS')) {
  header('HTTP/1.1 403 Forbidden');
  die();
}

class AppController
{

  /**
   * @param Engine $template
   * @return string
   */
  public function appAction(Engine $template): string
  {
    $html = $template->render('idx.template.php', [
      'title' => 'Lorem Ipsum',
      'description' => 'Lorem Ipsum Dolor Sit Amet.',
      'author' => 'Yami-no-karuro'
    ]);

    return $html;
  }
}
