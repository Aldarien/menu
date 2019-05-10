<?php
namespace App\Middleware;

use Psr\Container\ContainerInterface;
use App\Service\Migrator;

class ModelMigrator {
  protected $container;

  public function __construct(ContainerInterface $container){
    $this->container = $container;
  }
  public function __invoke($request, $response, $next) {
    $migrator = new Migrator($this->container);
    $migrator->load($this->container->cfg->get('locations.models.migrations'))->check()->migrate();
    return $next($request, $response);
  }
}
