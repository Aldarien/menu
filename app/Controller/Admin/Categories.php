<?php
namespace App\Controller\Admin;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use App\Definition\Controller;
use Menu\Category;

class Categories extends Controller {
  public function list(RequestInterface $request, ResponseInterface $response, $arguments) {
    $categories = $this->container->model->find(Category::class)->sort('description')->many();
    return $this->container->view->render($response, 'admin.categories.list', compact('categories'));
  }
  public function show(RequestInterface $request, ResponseInterface $response, $arguments) {
    $category = $this->container->model->find(Category::class)->one($arguments['category']);
    return $this->container->view->render($response, 'admin.categories.show', compact('category'));
  }
  public function add(RequestInterface $request, ResponseInterface $response, $arguments) {
    return $this->container->view->render($response, 'admin.categories.add');
  }
  public function do_add(RequestInterface $request, ResponseInterface $response, $arguments) {
    $post = $request->getParsedBody();
    $data = [
      'description' => $post['description']
    ];
    $category = $this->container->model->create(Category::class, $data);
    $category->save();
    return $response->withRedirect($this->container->base_url . '/admin/categories');
  }
}
