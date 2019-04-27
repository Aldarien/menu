<?php
namespace App\Controller\Admin;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use App\Definition\Controller;
use Menu\Ingredient;
use Menu\IngredientType;

class IngredientsTypes extends Controller {
  public function add(RequestInterface $request, ResponseInterface $response, $arguments) {
    if (isset($arguments['ingredient'])) {
      $ingredient = $this->container->model->find(Ingredient::class)->one($arguments['ingredient']);
      $types = $this->container->model->find(IngredientType::class)->sort(['description'])->many();
      return $this->container->view->render($response, 'admin.ingredients.types.add', compact('ingredient', 'types'));
    }
    if (isset($arguments['type'])) {
      $type = $this->container->model->find(IngredientType::class)->one($arguments['type']);
      $ingredients = $this->container->model->find(Ingredient::class)->sort(['description'])->many();
      return $this->container->view->render($response, 'admin.ingredienttypes.ingredients.add', compact('ingredients', 'type'));
    }
  }
  public function do_add(RequestInterface $request, ResponseInterface $response, $arguments) {
    if (isset($arguments['ingredient'])) {
      $ingredient = $this->container->model->find(Ingredient::class)->one($arguments['ingredient']);
      $post = $request->getParsedBody();
      foreach ($post['types'] as $type) {
        $ingredient->addType($type);
      }
      return $response->withRedirect($this->container->base_url . '/admin/ingredient/' . $ingredient->id);
    }
  }
}
