<?php
namespace App\Controller\Admin;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use App\Definition\Controller;
use Menu\Ingredient;

class Ingredients extends Controller {
  public function list(RequestInterface $request, ResponseInterface $response, $arguments) {
    $ingredients = $this->container->model->find(Ingredient::class)->sort(['description'])->many();
    return $this->container->view->render($response, 'admin.ingredients.list', compact('ingredients'));
  }
  public function show(RequestInterface $request, ResponseInterface $response, $arguments) {
    $ingredient = $this->container->model->find(Ingredient::class)->one($arguments['ingredient']);
    return $this->container->view->render($response, 'admin.ingredients.show', compact('ingredient'));
  }
}
