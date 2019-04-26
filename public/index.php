<?php
$include = [
  dirname(__DIR__),
  'bootstrap',
  'public.php'
];
include_once implode(DIRECTORY_SEPARATOR, $include);

$include = [
  $container->cfg->get('locations.routes'),
  'public.php'
];
include_once implode(DIRECTORY_SEPARATOR, $include);

$app->run();
