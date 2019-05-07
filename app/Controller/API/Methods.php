<?php
namespace App\Controller\API;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use App\Definition\Controller;
use Menu\Method;

class Methods extends Controller {
  public function __invoke(RequestInterface $request, ResponseInterface $response, $arguments) {
    $methods = $this->container->model->find(Method::class)->sort('description')->array();
    return $response->withJSON(compact('methods'));
  }
}
