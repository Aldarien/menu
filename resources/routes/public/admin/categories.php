<?php
use App\Controller\Admin\Categories;
use App\Controller\Admin\RecipesCategories;

$app->group('/categories', function($app) {
  $app->get('', Categories::class . ':list');
  $app->group('/add', function($app) {
    $app->get('', Categories::class . ':add');
    $app->post('', Categories::class . ':do_add');
  });
});
$app->group('/category/{category}', function($app) {
  $app->group('/edit', function($app) {
    $app->get('', Categories::class . ':edit');
    $app->post('', Categories::class . ':do_edit');
  });
  $app->group('/recipes', function($app) {
    $app->group('/add', function($app) {
      $app->get('', RecipesCategories::class . ':add');
      $app->post('', RecipesCategories::class . ':do_add');
    });
  });
  $app->get('/remove', Categories::class . ':remove');
  $app->group('/recipe/{recipe}', function($app) {
    $app->get('/remove', Categories::class . ':remove_recipe');
  });
  $app->get('', Categories::class . ':show');
});
