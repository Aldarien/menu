<?php
use App\Controller\Admin\Admin;

$app->group('/admin', function($app) {
  $app->get('', Admin::class);

  include_once 'admin/ingredients.php';
});
