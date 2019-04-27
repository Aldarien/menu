<?php
use App\Controller\Admin\Ingredients;
use App\Controller\Admin\IngredientsTypes;

$app->group('/ingredients', function($app) {
  $app->get('', Ingredients::class . ':list');
});

$app->group('/ingredient/{ingredient}', function($app) {
  $app->get('/edit', Ingredients::class . ':edit');
  $app->get('/remove', Ingredients::class . ':remove');
  $app->group('/types', function($app) {
    $app->get('/add', IngredientsTypes::class . ':add');
    $app->post('/add', IngredientsTypes::class . ':do_add');
  });
  $app->get('', Ingredients::class . ':show');
});
