<?php
include_once dirname(__DIR__) . '/slim/config.php';
$cfg->set('locations.base', realpath($cfg->get('locations.base') . '/..'));
