<?php
use App\Controller\Frontend;

$app->get('/', Frontend::class);

$files = new DirectoryIterator(realpath($app->getContainer()->cfg->get('locations.routes') . '/public'));
foreach ($files as $file) {
  if ($file->isDir()) {
    continue;
  }
  include_once $file->getRealPath();
}
