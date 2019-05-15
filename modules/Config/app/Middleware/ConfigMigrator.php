<?php
namespace App\Middleware;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use App\Service\Migrator;

class ConfigMigrator {
  protected $container;

  public function __construct(ContainerInterface $container){
    $this->container = $container;
  }
  public function __invoke(RequestInterface $request, ResponseInterface $response, $next) {
    $migrator = new Migrator($this->container);
    $migrator->load($this->container->cfg->get('locations.configs.migrations'))->check()->migrate();
    return $next($request, $response);
  }
}
