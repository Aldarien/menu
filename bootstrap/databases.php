<?php
use App\Service\DBConfigLoader;

$loader = new DBConfigLoader($cfg);
$loader->load()->shortTables();
