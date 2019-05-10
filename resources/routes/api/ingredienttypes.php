<?php
use App\Controller\API\IngredientTypes;

$app->group('/ingredienttypes', function($app) {
  $app->get('[/]', IngredientTypes::class);
});
