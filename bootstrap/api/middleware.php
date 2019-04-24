<?php
$app->add(new \Zeuxisoo\Whoops\Provider\Slim\WhoopsMiddleware($app));
$app->add(function($request, $response, $next) {
  $start = microtime(true);
  $response = $next($request, $response);
  $end = microtime(true) - $start;
  $response->getBody()->rewind();
  $object = json_decode($response->getBody());
  $object['benchmark'] = $end;
  return $response->withJSON($object);
});
