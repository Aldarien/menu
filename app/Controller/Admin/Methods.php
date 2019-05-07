<?php
namespace App\Controller\Admin;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use App\Definition\Controller;
use Menu\Method;

class Methods extends Controller {
  public function list(RequestInterface $request, ResponseInterface $response, $arguments) {
    $methods = $this->container->model->find(Method::class)->sort('description')->many();
    return $this->container->view->render($response, 'admin.methods.list', compact('methods'));
  }
  public function add(RequestInterface $request, ResponseInterface $response, $arguments) {
    return $this->container->view->render($response, 'admin.methods.add');
  }
  public function do_add(RequestInterface $request, ResponseInterface $response, $arguments) {
    $post = $request->getParsedBody();
    $data = [
      'description' => $post['description'],
      'vessel_id' => $post['vessel']
    ];
    $method = $this->container->model->create(Method::class, $data);
    $method->save();
    return $response->withRedirect($this->container->base_url . '/admin/methods');
  }
}
