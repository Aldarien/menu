<?php
namespace App\Controller\Admin;

use Psr\Container\ContainerInterface;
use Menu\Method;

class Methods extends Base {
  public function __construct(ContainerInterface $container) {
    parent::__construct($container);
    $this->singular = 'method';
    $this->plural = 'methods';
    $this->model = Method::class;
    $this->sort = 'description';
    $this->columns = ['description', 'vessel_id'];
  }
}
