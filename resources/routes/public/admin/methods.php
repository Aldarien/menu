<?php
use App\Controller\Admin\Methods;

$app->group('/methods', function($app) {
  $app->get('[/]', Methods::class);
  $app->group('/add', function($app) {
    $app->get('[/]', Methods::class . ':add');
    $app->post('[/]', Methods::class . ':do_add');
  });
});
$app->group('/method/{method}', function($app) {
  $app->group('/edit', function($app) {
    $app->get('[/]', Methods::class . ':edit');
    $app->post('[/]', Methods::class . ':do_edit');
  });
  $app->get('/remove[/]', Vessels::class . ':remove');
});
