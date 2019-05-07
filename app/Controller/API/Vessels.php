<?php
namespace App\Controller\API;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use App\Definition\Controller;
use Menu\Vessel;

class Vessels extends Controller {
  public function __invoke(RequestInterface $request, ResponseInterface $response, $arguments) {
    $vessels = $this->container->model->find(Vessel::class)->sort('description')->array();
    return $response->withJSON(compact('vessels'));
  }
}
