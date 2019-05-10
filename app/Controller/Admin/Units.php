<?php
namespace App\Controller\Admin;

use Psr\Container\ContainerInterface;
use Menu\Unit;

class Units extends Base {
  public function __construct(ContainerInterface $container) {
    parent::__construct($container);
    $this->singular = 'unit';
    $this->plural = 'units';
    $this->model = Unit::class;
    $this->sort = 'description';
    $this->columns = ['description', 'abreviation'];
  }
}
