<?php
namespace App\Controller\Admin;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use App\Definition\Controller;

class Admin extends Controller {
  public function config(RequestInterface $request, ResponseInterface $response, $arguments) {
    $config = $this->container->cfg;
    $timezones = \DateTimeZone::listIdentifiers();
    return $this->container->view->render($response, 'admin.config', compact('config', 'timezones'));
  }
  public function do_config(RequestInterface $request, ResponseInterface $response, $arguments) {
    $post = $request->getParsedBody();
    !d($post);
  }
}
