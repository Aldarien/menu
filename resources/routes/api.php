<?php
use App\Controller\API;

$app->get('/', API::class);

include_once 'api/categories.php';
