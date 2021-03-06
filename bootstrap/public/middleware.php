<?php
include_once dirname(__DIR__) . '/slim/middleware.php';

$app->add(function($request, $response, $next) {
  if (!file_exists($this->settings['renderer']['blade_cache_path'])) {
    mkdir($this->settings['renderer']['blade_cache_path']);
  }
  return $next($request, $response);
});
/*$app->add(function($request, $response, $next) {
  $start = microtime(true);
  $response = $next($request, $response);
  $end = microtime(true) - $start;
  return $this->view->render($response, 'benchmark', ['time' => round($end, 3) . 's']);
});*/
