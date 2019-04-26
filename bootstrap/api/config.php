<?php
use App\Service\Config;

$cfg = new Config(dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'config');
$cfg->set('locations.base', '../..');
$config = [
  "settings" => [
    'debug' => $cfg->get('app.debug'),
    'displayErrorDetails' => $cfg->get('app.debug')
  ]
];
