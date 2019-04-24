<?php
use App\Service\Config;

$include = [
  dirname(dirname(__DIR__)),
  'bootstrap',
  'api.php'
];
include_once implode(DIRECTORY_SEPARATOR, $include);

$include = [
  (new Config())->get('locations.routes'),
  'api.php'
];
include_once implode(DIRECTORY_SEPARATOR, $include);

$app->run();
