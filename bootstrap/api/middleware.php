<?php
include_once dirname(__DIR__) . '/slim/middleware.php';

/*$app->add(function($request, $response, $next) {
  $start = microtime(true);
  $response = $next($request, $response);
  $end = microtime(true) - $start;
  $response->getBody()->rewind();
  $object = (array) json_decode($response->getBody());
  $object['benchmark'] = ['Time' => $end];
  return $response->withJSON($object);
});*/
