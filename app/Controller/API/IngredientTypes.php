<?php
namespace App\Controller\API;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use App\Definition\Controller;
use Menu\IngredientType;

class IngredientTypes extends Controller {
  public function __invoke(RequestInterface $request, ResponseInterface $response, $arguments) {
    $types = $this->container->model->find(IngredientType::class)->sort('description')->many();
    return $response->withJSON(['ingredienttypes' => $types]);
  }
}
