<?php
namespace App\Controller\API;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use App\Definition\Controller;
use Menu\Ingredient;

class Ingredients extends Controller {
  public function __invoke(RequestInterface $request, ResponseInterface $response, $arguments) {
    $ingredients = $this->container->model->find(Ingredient::class)->sort('description')->array();
    return $response->withJSON(compact('ingredients'));
  }
}
