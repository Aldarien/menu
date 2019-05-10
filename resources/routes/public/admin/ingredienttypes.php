<?php
use App\Controller\Admin\IngredientTypes;

$app->group('/ingredienttypes', function($app) {
  $app->get('[/]', IngredientTypes::class);
  $app->group('/add', function($app) {
    $app->get('[/]', IngredientTypes::class . ':add');
    $app->post('[/]', IngredientTypes::class . ':do_add');
  });
});
$app->group('/ingredienttype/{ingredienttype}', function($app) {
  $app->group('/edit', function($app) {
    $app->get('[/]', IngredientTypes::class . ':edit');
    $app->post('[/]', IngredientTypes::class . ':do_edit');
  });
  $app->get('/remove[/]', IngredientTypes::class . ':remove');
});
