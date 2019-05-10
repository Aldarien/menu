<?php
use App\Controller\Admin\Units;

$app->group('/units', function($app) {
  $app->get('[/]', Units::class . ':list');
  $app->group('/add', function($app) {
    $app->get('[/]', Units::class . ':add');
    $app->post('[/]', Units::class . ':do_add');
  });
});
$app->group('/unit/{unit}', function($app) {
  $app->group('/edit', function($app) {
    $app->get('[/]', Units::class . ':edit');
    $app->post('[/]', Units::class . ':do_edit');
  });
  $app->get('/remove[/]', Units::class . ':remove');
});
