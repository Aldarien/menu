<?php
namespace App\Controller\Admin;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use App\Definition\Controller;
use Menu\Vessel;

class Vessels extends Controller {
  public function list(RequestInterface $request, ResponseInterface $response, $arguments) {
    $vessels = $this->container->model->find(Vessel::class)->sort('description')->many();
    return $this->container->view->render($response, 'admin.vessels.list', compact('vessels'));
  }
  public function show(RequestInterface $request, ResponseInterface $response, $arguments) {
    $vessel = $this->container->model->find(Vessel::class)->one($arguments['vessel']);
    return $this->container->view->render($response, 'admin.vessels.show', compact('vessel'));
  }
  public function add(RequestInterface $request, ResponseInterface $response, $arguments) {
    return $this->container->view->render($response, 'admin.vessels.add');
  }
  public function do_add(RequestInterface $request, ResponseInterface $response, $arguments) {
    $post = $request->getParsedBody();
    $data = [
      'description' => $post['description']
    ];
    $vessel = $this->container->model->create(Vessel::class, $data);
    $vessel->save();
    return $response->withRedirect($this->container->base_url . '/admin/vessels');
  }
}
