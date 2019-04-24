<?php
use App\Service\Config;

$cfg = new Config();
$config = [
  "settings" => [
    'debug' => $cfg->get('app.debug'),
    'displayErrorDetails' => $cfg->get('app.debug')
  ]
];
