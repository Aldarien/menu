<?php
namespace App\Controller\Admin;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use App\Definition\Controller;
use Menu\IngredientType;

class IngredientTypes extends Controller {
  public function list(RequestInterface $request, ResponseInterface $response, $arguments) {
    $types = $this->container->model->find(IngredientType::class)->sort(['description'])->many();
    return $this->container->view->render($response, 'admin.ingredienttypes.list', compact('types'));
  }
  public function show(RequestInterface $request, ResponseInterface $response, $arguments) {
    $type = $this->container->model->find(IngredientType::class)->one($arguments['ingredienttype']);
    return $this->container->view->render($response, 'admin.ingredienttypes.show', compact('type'));
  }
  public function add(RequestInterface $request, ResponseInterface $response, $arguments) {
    return $this->container->view->render($response, 'admin.ingredienttypes.add');
  }
  public function do_add(RequestInterface $request, ResponseInterface $response, $arguments) {
    $post = $request->getParsedBody();
    $data = ['description' => strtolower($post['description'])];
    $it = $this->container->model->create(IngredientType::class, $data);
    $it->save();
    return $response->withRedirect($this->container->base_url . '/admin/ingredienttypes');
  }
  public function remove(RequestInterface $request, ResponseInterface $response, $arguments) {
    $type = $this->container->model->find(IngredientType::class)->one($arguments['ingredienttype']);
    if ($type) {
      $type->delete();
      $this->container->model->reset(IngredientType::class);
    }
    return $response->withRedirect($this->container->base_url . '/admin/ingredienttypes');
  }
  public function remove_ingredient(RequestInterface $request, ResponseInterface $response, $arguments) {
    $type = $this->container->model->find(IngredientType::class)->one($arguments['ingredienttype']);
    $type->removeIngredient($arguments['ingredient']);
    $this->container->model->reset('ingredients_types');
    return $response->withRedirect($this->container->base_url . '/admin/ingredienttype/' . $type->id);
  }
}
