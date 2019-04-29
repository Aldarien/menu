<?php
use App\Controller\Admin\Admin;

$app->group('/admin', function($app) {
  $app->get('', Admin::class . ':config');
  $app->post('/config', Admin::class . ':do_config');

  include_once 'admin/ingredients.php';
  include_once 'admin/ingredienttypes.php';
});
