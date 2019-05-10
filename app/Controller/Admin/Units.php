<?php
namespace App\Controller\Admin;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use App\Definition\Controller;
use Menu\Unit;

class Units extends Controller {
  public function list(RequestInterface $request, ResponseInterface $response, $arguments) {
    $units = $this->container->model->find(Unit::class)->sort('description')->many();
    return $this->container->view->render($response, 'admin.units.list', compact('units'));
  }
  public function add(RequestInterface $request, ResponseInterface $response, $arguments) {
    return $this->container->view->render($response, 'admin.units.add');
  }
  public function do_add(RequestInterface $request, ResponseInterface $response, $arguments) {
    $post = $request->getParsedBody();
    $data = [
      'description' => $post['description'],
      'abreviation' => $post['abreviation']
    ];
    $unit = $this->container->model->create(Unit::class, $data);
    $unit->save();
    return $response->withRedirect($this->container->base_url . '/admin/units');
  }
  public function edit(RequestInterface $request, ResponseInterface $response, $arguments) {
    $unit = $this->container->model->find(Unit::class)->one($arguments['unit']);
    return $this->container->view->render($response, 'admin.units.edit', compact('unit'));
  }
  public function do_edit(RequestInterface $request, ResponseInterface $response, $arguments) {
    $unit = $this->container->model->find(Unit::class)->one($arguments['unit']);
    $post = $request->getParsedBody();
    $data = [
      'description' => $post['description'],
      'abreviation' => $post['abreviation']
    ];
    $changed = false;
    foreach ($data as $field => $value) {
      if ($unit->$field != $value) {
        $unit->$field = $value;
        $changed = true;
      }
    }
    if ($changed) {
      $unit->save();
    }
    return $response->withRedirect($this->container->base_url . '/admin/units');
  }
}
