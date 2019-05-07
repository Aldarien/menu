<?php
namespace App\Controller\Admin;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use App\Definition\Controller;
use Menu\Ingredient;

class Ingredients extends Controller {
  public function list(RequestInterface $request, ResponseInterface $response, $arguments) {
    $ingredients = $this->container->model->find(Ingredient::class)->sort('description')->many();
    return $this->container->view->render($response, 'admin.ingredients.list', compact('ingredients'));
  }
  public function show(RequestInterface $request, ResponseInterface $response, $arguments) {
    $ingredient = $this->container->model->find(Ingredient::class)->one($arguments['ingredient']);
    return $this->container->view->render($response, 'admin.ingredients.show', compact('ingredient'));
  }
  public function add(RequestInterface $request, ResponseInterface $response, $arguments) {
    return $this->container->view->render($response, 'admin.ingredients.add');
  }
  public function do_add(RequestInterface $request, ResponseInterface $response, $arguments) {
    $post = $request->getParsedBody();
    $data = ['description' => strtolower($post['description'])];
    $it = $this->container->model->create(Ingredient::class, $data);
    $it->save();
    return $response->withRedirect($this->container->base_url . '/admin/ingredients');
  }
  public function remove(RequestInterface $request, ResponseInterface $response, $arguments) {
    $ingredient = $this->container->model->find(Ingredient::class)->one($arguments['ingredient']);
    if ($ingredient) {
      $ingredient->delete();
      $this->container->model->reset(Ingredient::class);
    }
    return $response->withRedirect($this->container->base_url . '/admin/ingredients');
  }
  public function remove_type(RequestInterface $request, ResponseInterface $response, $arguments) {
    $ingredient = $this->container->model->find(Ingredient::class)->one($arguments['ingredient']);
    $ingredient->removeType($arguments['ingredienttype']);
    $this->container->model->reset('ingredients_types');
    return $response->withRedirect($this->container->base_url . '/admin/ingredient/' . $type->id);
  }
}
