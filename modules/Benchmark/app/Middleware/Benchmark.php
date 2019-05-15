<?php
namespace App\Middleware;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Benchmark {
  protected $container;
  protected $start;
  public function __construct(\Slim\App $app) {
    $this->container = $app->getContainer();
    $this->start = microtime(true);
  }
  public function __invoke(RequestInterface $request, ResponseInterface $response, $next) {
    if ($this->container->cfg->get('app.debug') == false) {
      return $next($request, $response);
    }
    $response = $next($request, $response);
    $end = microtime(true) - $this->start;
    if ($response->hasHeader('Content-Type') and $response->getHeaders('Content-Type') == 'application/json;charset=utf-8') {
      $response->getBody()->rewind();
      $object = (array) json_decode($response->getBody());
      $object['benchmark'] = ['Time' => $end];
      return $response->withJSON($object);
    }
    return $this->container->view->render($response, 'benchmark', ['time' => round($end, 3) . 's']);
  }
}
