<?php
use App\Controller\Admin\Admin;

$app->group('/admin', function($app) {
  $app->get('[/]', Admin::class . ':config');
  $app->post('/config', Admin::class . ':do_config');

  $files = new DirectoryIterator(realpath($app->getContainer()->cfg->get('locations.routes') . '/public/admin'));
  foreach ($files as $file) {
    if ($file->isDir() or $file->getExtension() != 'php') {
      continue;
    }
    include_once $file->getRealPath();
  }
});
