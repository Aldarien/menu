<?php
use App\Controller\Book\Ingredients;

$app->group('/ingredients', function($app) {
  $app->get('[/]', Ingredients::class);
  $app->group('/add', function($app) {
    $app->get('[/]', Ingredients::class . ':add');
    $app->post('[/]', Ingredients::class . ':do_add');
  });
});
$app->group('/ingredient/{ingredient}', function($app) {
  $app->get('[/]', Ingredients::class . ':show');
  $app->group('/edit', function($app) {
    $app->get('[/]', Ingredients::class . ':edit');
    $app->post('[/]', Ingredients::class . ':do_edit');
  });
  $app->get('/remove[/]', Ingredients::class . ':remove');
});
