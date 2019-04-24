<?php
namespace App\Controller;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use App\Definition\Controller;

class API extends Controller {
  public function __invoke(RequestInterface $request, ResponseInterface $response, $arguments) {
    $migrator = new \App\Service\ModelMigrator($this->container);
    $migrator->load()->create();
    die();
    $types = $this->container->model->find(\Menu\Recipe::class)->array();
    $output = $types;
    return $response->withJSON($output);
  }
}
