<?php
use App\Controller\Admin\Vessels;

$app->group('/vessels', function($app) {
  $app->get('[/]', Vessels::class . ':list');
  $app->group('/add', function($app) {
    $app->get('[/]', Vessels::class . ':add');
    $app->post('[/]', Vessels::class . ':do_add');
  });
});
$app->group('/vessel/{vessel}', function($app) {
  $app->group('/edit', function($app) {
    $app->get('[/]', Vessels::class . ':edit');
    $app->post('[/]', Vessels::class . ':do_edit');
  });
  $app->get('/remove[/]', Vessels::class . ':remove');
});
