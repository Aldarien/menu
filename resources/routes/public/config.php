<?php
use App\Controller\Config;

$app->group('/config', function($app) {
  $app->get('[/]', Config::class);
  $app->post('[/]', Config::class . ':do_config');
});
