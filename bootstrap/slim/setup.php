<?php
$container = $app->getContainer();

$container['model'] = function($container) {
  return new App\Service\ModelFactory($container);
};
$container['cfg'] = function($container) {
  $cfg = new App\Service\Config(dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'config');
  $cfg->dbload($container);
  return $cfg;
};
$container['pdo'] = function($container) {
  return \ORM::getDb();
};
$container['random_recipe'] = function($container) {
  return new App\Service\RandomRecipe($container);
};
