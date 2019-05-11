<?php
use App\Controller\API\Categories;

$app->group('/categories', function($app) {
  $app->get('', Categories::class);
});
