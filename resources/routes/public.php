<?php
use App\Controller\Planner\Week;

$app->get('/', Week::class);

$files = new DirectoryIterator(realpath($app->getContainer()->cfg->get('locations.routes') . '/public'));
foreach ($files as $file) {
  if ($file->isDir()) {
    continue;
  }
  include_once $file->getRealPath();
}
