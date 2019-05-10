<?php
namespace App\Middleware;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\App;
use App\Middleware\ModelMigrator;
use App\Middleware\ConfigMigrator;

class Migrator {
  protected $app;
  protected $migrators;

  public function __construct(App &$app){
    $this->app = $app;

    $this->migrators = [];
    $this->migrators []= new ModelMigrator($app->getContainer());
    $this->migrators []= new ConfigMigrator($app->getContainer());

    foreach ($this->migrators as $migrator) {
      $app->add($migrator);
    }
  }
  public function __invoke(RequestInterface $request, ResponseInterface $response, $next) {
    /*foreach ($this->migrators as $migrator) {
      $response = $migrator->__invoke($request, $response, $next);
    }*/
    return $next($request, $response);
  }
}
