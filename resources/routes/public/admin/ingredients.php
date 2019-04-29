<?php
use App\Controller\Admin\Ingredients;
use App\Controller\Admin\IngredientsTypes;

$app->group('/ingredients', function($app) {
  $app->get('', Ingredients::class . ':list');
  $app->group('/add', function($app) {
    $app->get('', Ingredients::class . ':add');
    $app->post('', Ingredients::class . ':do_add');
  });
});
$app->group('/ingredient/{ingredient}', function($app) {
  $app->group('/edit', function($app) {
    $app->get('', Ingredients::class . ':edit');
    $app->post('', Ingredients::class . ':do_edit');
  });
  $app->group('/types', function($app) {
    $app->group('/add', function($app) {
      $app->get('', IngredientsTypes::class . ':add');
      $app->post('', IngredientsTypes::class . ':do_add');
    });
  });
  $app->get('/remove', Ingredients::class . ':remove');
  $app->group('/type/{ingredienttype}', function($app) {
    $app->get('/remove', Ingredients::class . ':remove_type');
  });
  $app->get('', Ingredients::class . ':show');
});
