<?php
namespace App\Controller\API;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use App\Definition\Controller;
use Menu\Unit;

class Units extends Controller {
  public function __invoke(RequestInterface $request, ResponseInterface $response, $arguments) {
    $units = $this->container->model->find(Unit::class)->sort('description')->array();
    return $response->withJSON(compact('units'));
  }
}
