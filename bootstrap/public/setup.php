<?php
include_once dirname(__DIR__) . '/slim/setup.php';

$container['base_url'] = function($c) {
  $base = [];
  $base []= $_SERVER['REQUEST_SCHEME'] . '://';
  $base []= $_SERVER['HTTP_HOST'];
  if ($_SERVER['SERVER_PORT'] != 80) {
    $base []= ':' . $_SERVER['SERVER_PORT'];
  }
  $base []= str_replace('//', '/', '/' . $c->cfg->get('app.base_url'));
  return implode('', $base);
};
$container['view'] = function ($container) {
  return new \Slim\Views\Blade(
    $container['settings']['renderer']['blade_template_path'] . DIRECTORY_SEPARATOR . $container->cfg->get('app.template'),
    $container['settings']['renderer']['blade_cache_path'],
    null,
    [
      'container' => $container,
      'base_url' => $container->base_url
    ]
  );
};
