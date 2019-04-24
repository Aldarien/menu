<?php
namespace App\Definition;

use Psr\Container\ContainerInterface;

class Model extends \Model {
  protected $container;
  public function setContainer(ContainerInterface $container) {
    $this->container = $container;
  }
}
