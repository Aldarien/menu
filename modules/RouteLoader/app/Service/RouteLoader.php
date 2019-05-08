<?php
namespace App\Service;

use Slim\App;

class RouteLoader {
  protected $app;
  protected $data;

  public function __construct(App $app) {
    $this->app = $app;
  }
  public function load($directory) {
    $files = new \DirectoryIterator($directory);
    foreach ($files as $file) {
      if ($file->isDir() or $file->getExtension() == 'php') {
        continue;
      }
      $loader = implode("\\", ["Loader", str_replace('YML', 'YAML', strtoupper($file->getExtension()) . 'Loader')]);
      if (!class_exists($loader)) {
        continue;
      }
      $loader = new $loader($directory . DIRECTORY_SEPARATOR . $file->getFilename());
      $data = $this->parseData($loader->load());
    }
  }
  public function register() {
  }
  protected function parseData($data) {
    $routes = [];
    if (isset($data->controller)) {
      $controller = $data->controller;
      if (is_object($controller)) {
        $controller = implode("\\", (array) $controller);
      }
    }
    foreach ($data->routes as $route) {
      $r = [
        $route->name => null
      ];
      if (isset($route->group)) {
        $r[$route->name] = $this->parseData($route->group);
      }
    }
    !d($data);
    die();
  }
}
