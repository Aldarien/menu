<?php
use App\Service\Config;

$cfg = new Config(dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'config');
$config = [
  "settings" => [
    'debug' => $cfg->get('app.debug'),
    'displayErrorDetails' => $cfg->get('app.debug')
  ]
];
