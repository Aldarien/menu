<?php
namespace App\Controller;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use App\Definition\Controller;
use Menu\RecipeCategory;

class RecipeCategories extends Controller {
  public function api_list(RequestInterface $request, ResponseInterface $response, $arguments) {
    $categories = $this->container->model->find(RecipeCategory::class)->sort(['description'])->array();
    return $response->withJSON(compact('categories'));
  }
}
