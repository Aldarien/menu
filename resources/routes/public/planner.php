<?php
use App\Controller\Planner\Week;
use App\Controller\Planner\Day;
use App\Controller\Planner\Month;
use App\Controller\Planner\Year;

$app->group('/planner', function($app) {
  $app->get('[/]', Week::class);
  $app->group('/week', function($app) {
    $app->get('[/]', Week::class);
    $app->get('/{week}[/]', Week::class);
  });
  $app->group('/year', function($app) {
    $app->get('[/]', Year::class);
    $app->get('/{year}[/]', Year::class);
  });
  $app->group('/month', function($app) {
    $app->get('[/]', Month::class);
    $app->get('/{month}[/]', Month::class);
  });
  $app->group('/day', function($app) {
    $app->get('[/]', Day::class);
    $app->get('/{day}[/]', Day::class);
  });
  /*$files = new DirectoryIterator(realpath($app->getContainer()->cfg->get('locations.routes') . '/public/planner'));
  foreach ($files as $file) {
    if ($file->isDir() or $file->getExtension() != 'php') {
      continue;
    }
    include_once $file->getRealPath();
  }*/
});
