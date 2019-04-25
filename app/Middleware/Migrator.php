<?php
namespace App\Middleware;

use Psr\Container\ContainerInterface;
use App\Service\ModelMigrator;

class Migrator {
  protected $container;

  public function __construct(ContainerInterface $container){
    $this->container = $container;
  }
  public function __invoke($request, $response, $next) {
    $migrator = new ModelMigrator($this->container);
    $migrator->load()->check()->migrate();
    die();
    return $next($request, $response);
  }
}
