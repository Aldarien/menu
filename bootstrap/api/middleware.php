<?php
$app->add(new \Zeuxisoo\Whoops\Provider\Slim\WhoopsMiddleware($app));
$app->add(new App\Middleware\Migrator($app->getContainer()));
$app->add(function($request, $response, $next) {
  $start = microtime(true);
  $response = $next($request, $response);
  $end = microtime(true) - $start;
  $response->getBody()->rewind();
  $object = (array) json_decode($response->getBody());
  $object['benchmark'] = ['Time' => $end];
  return $response->withJSON($object);
});
