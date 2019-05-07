<?php
use App\Controller\API\Vessels;

$app->group('/vessels', function($app) {
  $app->get('[/]', Vessels::class);
});
