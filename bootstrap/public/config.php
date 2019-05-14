<?php
include_once dirname(__DIR__) . '/slim/config.php';

$config["settings"]['renderer'] = [
  'blade_template_path' => $cfg->get('locations.views'),
  'blade_cache_path'    => $cfg->get('locations.cache')
];
