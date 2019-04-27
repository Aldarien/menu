<?php
use App\Controller\Frontend;

$app->get('/', Frontend::class);

include_once 'public/admin.php';
