<?php
use App\Controller\API\Ingredients;

$app->group('/ingredients', function($app) {
  $app->get('[/]', Ingredients::class);
});
