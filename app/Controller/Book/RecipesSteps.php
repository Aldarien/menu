<?php
namespace App\Controller\Book;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use App\Definition\Controller;
use Menu\Recipe;

class RecipesSteps extends Controller {
  public function add(RequestInterface $request, ResponseInterface $response, $arguments) {
    $recipe = $this->container->model->find(Recipe::class)->one($arguments['recipe']);
    return $this->container->view->render($response, 'book.recipes.steps.add', compact('recipe'));
  }
  public function do_add(RequestInterface $request, ResponseInterface $response, $arguments) {
    $recipe = $this->container->model->find(Recipe::class)->one($arguments['recipe']);
    $post = $request->getParsedBody();
    $data = [
      'method_id' => $post['method']
    ];
    $step = $recipe->addStep($data);
    for ($i = 1; $i <= $post['ingredients']; $i ++) {
      $data = [
        'ingredient_id' => $post['ingredient' . $i],
        'amount' => $post['amount' . $i],
        'unit_id' => $post['unit' . $i]
      ];
      $step->addIngredient($data);
    }
    return $response->withRedirect($this->container->base_url . '/book/recipe/' . $recipe->id);
  }
}
