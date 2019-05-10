<?php
namespace App\Controller\Admin;

use Psr\Container\ContainerInterface;
use Menu\IngredientType;

class IngredientTypes extends Base {
  public function __construct(ContainerInterface $container) {
    parent::__construct($container);
    $this->singular = 'ingredienttype';
    $this->plural = 'ingredienttypes';
    $this->model = IngredientType::class;
    $this->sort = 'description';
    $this->columns = ['description', 'abreviation'];
  }
}
