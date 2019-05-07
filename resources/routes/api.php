<?php
use App\Controller\API;

$app->get('/', API::class);

$files = new DirectoryIterator(realpath($app->getContainer()->cfg->get('locations.routes') . '/api'));
foreach ($files as $file) {
  if ($file->isDir()) {
    continue;
  }
  include_once $file->getRealPath();
}
