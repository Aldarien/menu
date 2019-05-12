<?php
use App\Controller\API\Times;

$app->group('/times', function($app) {
  $app->get('[/]', Times::class);
});
