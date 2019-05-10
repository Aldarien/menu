<?php
use App\Controller\Admin\Categories;

$app->group('/categories', function($app) {
  $app->get('[/]', Categories::class);
  $app->group('/add', function($app) {
    $app->get('[/]', Categories::class . ':add');
    $app->post('[/]', Categories::class . ':do_add');
  });
});
$app->group('/category/{category}', function($app) {
  $app->group('/edit', function($app) {
    $app->get('[/]', Categories::class . ':edit');
    $app->post('[/]', Categories::class . ':do_edit');
  });
  $app->get('/remove[/]', Categories::class . ':remove');
});
