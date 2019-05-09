<?php
use App\Controller\Book\Recipes;

$app->group('/book', function($app) {
  $app->get('[/]', Recipes::class);
  $files = new DirectoryIterator(realpath($app->getContainer()->cfg->get('locations.routes') . '/public/book'));
  foreach ($files as $file) {
    if ($file->isDir() or $file->getExtension() != 'php') {
      continue;
    }
    include_once $file->getRealPath();
  }
});
