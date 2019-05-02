<?php
namespace App\Controller\Admin;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use App\Definition\Controller;
use Menu\Recipe;

class Recipes extends Controller {
  public function list(RequestInterface $request, ResponseInterface $response, $arguments) {
    $recipes = $this->container->model->find(Recipe::class)->sort(['title'])->many();
    return $this->container->view->render($response, 'admin.recipes.list', compact('recipes'));
  }
  public function show(RequestInterface $request, ResponseInterface $response, $arguments) {
    $recipe = $this->container->model->find(Recipe::class)->one($arguments['recipe']);
    return $this->container->view->render($response, 'admin.recipes.show', compact('recipe'));
  }
  public function add(RequestInterface $request, ResponseInterface $response, $arguments) {
    return $this->container->view->render($response, 'admin.recipes.add');
  }
  public function do_add(RequestInterface $request, ResponseInterface $response, $arguments) {
    $post = $request->getParsedBody();
    $data = [
      'title' => $post['title'],
      'image' => $post['image']
    ];
    $recipe = $this->container->model->create(Recipe::class, $data);
    $recipe->save();
    $categories = explode(',', $post['categories']);
    foreach ($categories as $category) {
      $recipe->addCategory($category);
    }
    return $response->withRedirect($this->container->base_url . '/admin/recipes');
  }
}
