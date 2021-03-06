<?php
namespace App\Controller\Book;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use App\Definition\Controller;

class Base extends Controller {
  protected $singular;
  protected $plural;
  protected $model;
  protected $sort;
  protected $columns;

  public function __invoke(RequestInterface $request, ResponseInterface $response, $arguments) {
    $objs = $this->container->model->find($this->model)->sort($this->sort)->many();
    return $this->container->view->render($response, 'book.' . $this->plural . '.list', [$this->plural => $objs]);
  }
  public function show(RequestInterface $request, ResponseInterface $response, $arguments) {
    $obj = $this->container->model->find($this->model)->one($arguments[$this->singular]);
    return $this->container->view->render($response, 'book.' . $this->plural . '.show', [$this->singular => $obj]);
  }
  public function add(RequestInterface $request, ResponseInterface $response, $arguments) {
    return $this->container->view->render($response, 'book.' . $this->plural . '.add');
  }
  public function do_add(RequestInterface $request, ResponseInterface $response, $arguments) {
    $post = $request->getParsedBody();
    $data = [];
    foreach ($this->columns as $column) {
      $data[$column] = $post[$column];
    }
    $obj = $this->container->model->create($this->model, $data);
    $obj->save();
    if (method_exists($this, 'extraAdd')) {
      $this->extraAdd($obj, $post);
    }
    return $response->withRedirect($this->container->base_url . '/book/' . $this->plural);
  }
  public function edit(RequestInterface $request, ResponseInterface $response, $arguments) {
    $obj = $this->container->model->find($this->model)->one($arguments[$this->singular]);
    return $this->container->view->render($response, 'book.' . $this->plural . '.edit', [$this->singular => $obj]);
  }
  public function do_edit(RequestInterface $request, ResponseInterface $response, $arguments) {
    $post = $request->getParsedBody();
    $obj = $this->container->model->find($this->model)->one($arguments[$this->singular]);
    $changed = false;
    foreach ($this->columns as $column) {
      if ($obj->$column != $post[$column]) {
        $obj->$column = $post[$column];
        $changed = true;
      }
    }
    if ($changed) {
      $obj->save();
    }
    if (method_exists($this, 'extraEdit')) {
      $this->extraEdit($obj, $post);
    }
    return $response->withRedirect($this->container->base_url . '/book/' . $this->singular . '/' . $obj->id);
  }
  public function remove(RequestInterface $request, ResponseInterface $response, $arguments) {
    $obj = $this->container->model->find($this->model)->one($arguments[$this->singular]);
    if ($obj) {
      $obj->delete();
    }
    return $response->withRedirect($this->container->base_url . '/book/' . $this->plural);
  }
}
