<?php
use App\Controller\Admin\IngredientTypes;
use App\Controller\Admin\IngredientsTypes;

$app->group('/ingredienttypes', function($app) {
  $app->get('', IngredientTypes::class . ':list');
  $app->group('/add', function($app) {
    $app->get('', IngredientTypes::class . ':add');
    $app->post('', IngredientTypes::class . ':do_add');
  });
});
$app->group('/ingredienttype/{ingredienttype}', function($app) {
  $app->group('/edit', function($app) {
    $app->get('', IngredientTypes::class . ':edit');
    $app->post('', IngredientTypes::class . ':do_edit');
  });
  $app->group('/ingredients', function($app) {
    $app->group('/add', function($app) {
      $app->get('', IngredientsTypes::class . ':add');
      $app->post('', IngredientsTypes::class . ':do_add');
    });
  });
  $app->get('/remove', IngredientTypes::class . ':remove');
  $app->group('/ingredient/{ingredient}', function($app) {
    $app->get('/remove', IngredientTypes::class . ':remove_ingredient');
  });
  $app->get('', IngredientTypes::class . ':show');
});
