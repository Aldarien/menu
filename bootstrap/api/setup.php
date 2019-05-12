<?php
$container = $app->getContainer();

$container['model'] = function($container) {
  return new App\Service\ModelFactory($container);
};
$container['cfg'] = function($c) {
  $cfg = new App\Service\Config(dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'config');
  $cfg->set('locations.base', '../..');
  $cfg->dbload($c);
  return $cfg;
};
$container['pdo'] = function($c) {
  return \ORM::getDb();
};
$container['random_recipe'] = function($c) {
  return new App\Service\RandomRecipe($c);
};
