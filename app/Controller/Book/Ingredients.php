<?php
namespace App\Controller\Book;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use App\Definition\Controller;
use Menu\Ingredient;

class Ingredients extends Controller {
  public function __invoke(RequestInterface $request, ResponseInterface $response, $arguments) {
    $ingredients = $this->container->model->find(Ingredient::class)->sort('description')->many();
    return $this->container->view->render($response, 'book.ingredients.list', compact('ingredients'));
  }
  public function show(RequestInterface $request, ResponseInterface $response, $arguments) {
    $ingredient = $this->container->model->find(Ingredient::class)->one($arguments['ingredient']);
    return $this->container->view->render($response, 'book.ingredients.show', compact('ingredient'));
  }
  public function add(RequestInterface $request, ResponseInterface $response, $arguments) {
    return $this->container->view->render($response, 'book.ingredients.add');
  }
  public function do_add(RequestInterface $request, ResponseInterface $response, $arguments) {
    $post = $request->getParsedBody();
    return $response->withRedirect($this->container->base_url . '/book/ingredients');
  }
  public function edit(RequestInterface $request, ResponseInterface $response, $arguments) {
    $ingredient = $this->container->model->find(Ingredient::class)->one($arguments['ingredient']);
    return $this->container->view->render($response, 'book.ingredients.edit', compact('ingredient'));
  }
  public function do_edit(RequestInterface $request, ResponseInterface $response, $arguments) {
    $post = $request->getParsedBody();
    $ingredient = $this->container->model->find(Ingredient::class)->one($arguments['ingredient']);
    $data = [
      'description' => $post['description']
    ];
    $changed = false;
    foreach ($data as $column => $value) {
      if ($ingredient->$column != $value) {
        $ingredient->$column = $value;
        $changed = true;
      }
    }
    if ($changed) {
      $ingredient->save();
    }
    $ingredient->resetTypes();
    $types = explode(',', $post['types']);
    foreach ($types as $type) {
      if ($type == '') {
        continue;
      }
      $ingredient->addType($type);
    }
    return $response->withRedirect($this->container->base_url . '/book/ingredients');
  }
}
