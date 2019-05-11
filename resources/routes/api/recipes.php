<?php
use App\Controller\API\Recipes;

$app->group('/recipes', function($app) {
  $app->post('/random[/]', Recipes::class . ':random');
});
$app->group('/recipe/{recipe}', function($app) {
  $app->get('/ingredients[/]', Recipes::class . ':ingredients');
});
