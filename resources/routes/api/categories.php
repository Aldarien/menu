<?php
use App\Controller\RecipeCategories;

$app->group('/recipecategories', function($app) {
  $app->get('', RecipeCategories::class . ':api_list');
});
