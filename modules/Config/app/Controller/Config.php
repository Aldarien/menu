<?php
namespace App\Controller;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use App\Definition\Controller;
use Config\Config as CModel;

class Config extends Controller {
  public function __invoke(RequestInterface $request, ResponseInterface $response, $arguments) {
    $configs = $this->container->model->find(CModel::class)->many();
    return $this->container->view->render($response, 'config', compact('configs'));
  }
  public function do_config(RequestInterface $request, ResponseInterface $response, $arguments) {
    $post = $request->getParsedBody();
    for ($i = 0; $i < $post['configs']; $i ++) {
      $data = [
        'value' => $post['config_' . $i . '_value']
      ];
      $config = $this->container->model->find(CModel::class)->one($post['config_' . $i . '_id']);
      $changed = false;
      foreach ($data as $column => $value) {
        if ($config->$column != $value) {
          $config->$column = $value;
          $changed = true;
        }
      }
      if ($changed) {
        $config->save();
      }
    }
    return $response->withRedirect($this->container->base_url . '/config');
  }
}
