<?php
namespace App\Controller\Admin;

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
    return $this->container->view->render($response, 'admin.' . $this->plural . '.list', [$this->plural => $objs]);
  }
  public function add(RequestInterface $request, ResponseInterface $response, $arguments) {
    return $this->container->view->render($response, 'admin.' . $this->plural . '.add');
  }
  public function do_add(RequestInterface $request, ResponseInterface $response, $arguments) {
    $post = $request->getParsedBody();
    $data = [];
    foreach ($this->columns as $column) {
      $data[$column] = $post[$column];
    }
    $obj = $this->container->model->create($this->model, $data);
    $obj->save();
    return $response->withRedirect($this->container->base_url . '/admin/' . $this->plural);
  }
  public function edit(RequestInterface $request, ResponseInterface $response, $arguments) {
    $obj = $this->container->model->find($this->model)->one($arguments[$this->singular]);
    return $this->container->view->render($response, 'admin.' . $this->plural . '.edit', [$this->singular => $obj]);
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
    return $response->withRedirect($this->container->base_url . '/admin/' . $this->plural);
  }
  public function remove(RequestInterface $request, ResponseInterface $response, $arguments) {
    $obj = $this->container->model->find($this->model)->one($arguments[$this->singular]);
    if ($obj) {
      $obj->delete();
    }
    return $response->withRedirect($this->container->base_url . '/admin/' . $this->plural);
  }
}
