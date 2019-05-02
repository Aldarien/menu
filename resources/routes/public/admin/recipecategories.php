<?php
use App\Controller\Admin\RecipeCategories;
use App\Controller\Admin\RecipesCategories;

$app->group('/recipecategories', function($app) {
  $app->get('', RecipeCategories::class . ':list');
  $app->group('/add', function($app) {
    $app->get('', RecipeCategories::class . ':add');
    $app->post('', RecipeCategories::class . ':do_add');
  });
});
$app->group('/recipecategory/{category}', function($app) {
  $app->group('/edit', function($app) {
    $app->get('', RecipeCategories::class . ':edit');
    $app->post('', RecipeCategories::class . ':do_edit');
  });
  $app->group('/recipes', function($app) {
    $app->group('/add', function($app) {
      $app->get('', RecipesCategories::class . ':add');
      $app->post('', RecipesCategories::class . ':do_add');
    });
  });
  $app->get('/remove', RecipeCategories::class . ':remove');
  $app->group('/recipe/{recipe}', function($app) {
    $app->get('/remove', RecipeCategories::class . ':remove_recipe');
  });
  $app->get('', RecipeCategories::class . ':show');
});
