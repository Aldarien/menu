<?php
namespace App\Controller\Admin;

use Psr\Container\ContainerInterface;
use Menu\Category;

class Categories extends Base {
  public function __construct(ContainerInterface $container) {
    parent::__construct($container);
    $this->singular = 'category';
    $this->plural = 'categories';
    $this->model = Category::class;
    $this->sort = 'description';
    $this->columns = ['description'];
  }
}
