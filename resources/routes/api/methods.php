<?php
use App\Controller\API\Methods;

$app->group('/methods', function($app) {
  $app->get('[/]', Methods::class);
});
