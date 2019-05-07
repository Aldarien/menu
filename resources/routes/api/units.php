<?php
use App\Controller\API\Units;

$app->group('/units', function($app) {
  $app->get('[/]', Units::class);
});
