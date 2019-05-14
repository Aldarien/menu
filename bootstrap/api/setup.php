<?php
include_once dirname(__DIR__) . '/slim/setup.php';

$container['cfg'] = function($c) {
  $cfg = new App\Service\Config(dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'config');
  $cfg->set('locations.base', '../..');
  $cfg->dbload($c);
  return $cfg;
};
