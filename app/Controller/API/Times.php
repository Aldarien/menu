<?php
namespace App\Controller\API;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use App\Definition\Controller;
use Meny\Time;

class Times extends Controller {
  public function __invoke(RequestInterface $request, ResponseInterface $response, $arguments) {
    $times = $this->container->model->find(Time::class)->sort('id')->many();
    return $response->withJSON(compact('times'));
  }
}
