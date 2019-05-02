<?php
use App\Controller\Admin\Recipes;
use App\Controller\Admin\RecipesCategories;
use App\Controller\Admin\RecipesSteps;

$app->group('/recipes', function($app) {
  $app->get('[/]', Recipes::class . ':list');
  $app->group('/add', function($app) {
    $app->get('[/]', Recipes::class . ':add');
    $app->post('[/]', Recipes::class . ':do_add');
  });
});
$app->group('/recipe/{recipe}', function($app) {
  $app->group('/edit', function($app) {
    $app->get('[/]', Recipes::class . ':edit');
    $app->post('[/]', Recipes::class . ':do_edit');
  });
  $app->get('/remove[/]', Recipes::class . ':remove');
  $app->group('/categories', function($app) {
    $app->group('/add', function($app) {
      $app->get('[/]', RecipesCategories::class . ':add');
      $app->post('[/]', RecipesCategories::class . ':do_add');
    });
  });
  $app->group('/category/{category}', function($app) {
    $app->get('/remove[/]', Recipes::class . ':remove_category');
  });
  $app->group('/steps', function($app) {
    $app->group('/add', function($app) {
      $app->get('[/]', RecipesSteps::class . ':add');
      $app->post('[/]', RecipesSteps::class . ':do_add');
    });
  });
  $app->get('[/]', Recipes::class . ':show');
});
