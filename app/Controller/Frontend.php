<?php
namespace App\Controller;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use App\Definition\Controller;

class Frontend extends Controller {
  public function __invoke(RequestInterface $request, ResponseInterface $response, $arguments) {
    $types = $this->container->model->find(\Menu\IngredientType::class)->many();
    return $this->container->view->render($response, 'home', compact('types'));
  }
}
