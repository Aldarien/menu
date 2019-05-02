<?php
namespace App\Controller\Admin;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use App\Definition\Controller;
use Menu\RecipeCategory;

class RecipeCategories extends Controller {
  public function list(RequestInterface $request, ResponseInterface $response, $arguments) {
    $categories = $this->container->model->find(RecipeCategory::class)->sort(['description'])->many();
    return $this->container->view->render($response, 'admin.recipes.categories.list', compact('categories'));
  }
  public function show(RequestInterface $request, ResponseInterface $response, $arguments) {
    $category = $this->container->model->find(RecipeCategory::class)->one($arguments['category']);
    return $this->container->view->render($response, 'admin.recipes.categories.show', compact('category'));
  }
  public function add(RequestInterface $request, ResponseInterface $response, $arguments) {
    return $this->container->view->render($response, 'admin.recipes.categories.add');
  }
  public function do_add(RequestInterface $request, ResponseInterface $response, $arguments) {
    $post = $request->getParsedBody();
    $data = [
      'description' => $post['description']
    ];
    $category = $this->container->model->create(RecipeCategory::class, $data);
    $category->save();
    return $response->withRedirect($this->container->base_url . '/admin/recipecategories');
  }
}
