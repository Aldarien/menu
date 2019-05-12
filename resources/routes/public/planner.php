<?php
use App\Controller\Planner\Week;
use App\Controller\Planner\Day;
use App\Controller\Planner\Month;
use App\Controller\Planner\Year;
use App\Controller\Planner\Ingredients;

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
  $app->group('/ingredients', function($app) {
    $app->get('[/]', Ingredients::class);
    $app->group('/{date}', function($app) {
      $app->get('[/]', Ingredients::class);
      $app->get('/{period}', Ingredients::class);
    });
  });
});
