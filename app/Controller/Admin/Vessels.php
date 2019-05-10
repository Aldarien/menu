<?php
namespace App\Controller\Admin;

use Psr\Container\ContainerInterface;
use Menu\Vessel;

class Vessels extends Base {
  public function __construct(ContainerInterface $container) {
    parent::__construct($container);
    $this->singular = 'vessel';
    $this->plural = 'vessels';
    $this->model = Vessel::class;
    $this->sort = 'description';
    $this->columns = ['description'];
  }
}
