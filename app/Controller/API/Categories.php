<?php
namespace App\Controller\API;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use App\Definition\Controller;
use Menu\Category;

class Categories extends Controller {
  public function __invoke(RequestInterface $request, ResponseInterface $response, $arguments) {
    $categories = $this->container->model->find(Category::class)->sort('description')->array();
    return $response->withJSON(compact('categories'));
  }
}
