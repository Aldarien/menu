<?php
namespace App\Controller\Book;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use App\Definition\Controller;
use Menu\Recipe;
use Menu\Category;

class RecipesCategories extends Controller {
  public function add(RequestInterface $request, ResponseInterface $response, $arguments) {
    $recipe = $this->container->model->find(Recipe::class)->one($arguments['recipe']);
    $categories = $this->container->model->find(Category::class)->sort(['description'])->many();
    return $this->container->view->render($response, 'book.recipes.categories.add', compact('recipe', 'categories'));
  }
  public function do_add(RequestInterface $request, ResponseInterface $response, $arguments) {
    $post = $request->getParsedBody();
    $recipe = $this->container->model->find(Recipe::class)->one($arguments['recipe']);
    $categories = explode(',', $post['categories']);
    foreach ($categories as $category_id) {
      $recipe->addCategory($category_id);
    }
    return $response->withRedirect($this->container->base_url . '/book/recipe/' . $recipe->id);
  }
}
