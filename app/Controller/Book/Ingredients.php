<?php
namespace App\Controller\Book;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Menu\Ingredient;

class Ingredients extends Base {
  public function __construct(ContainerInterface $container) {
    parent::__construct($container);
    $this->singular = 'ingredient';
    $this->plural = 'ingredients';
    $this->model = Ingredient::class;
    $this->sort = 'description';
    $this->columns = ['description'];
  }

  protected function extraAdd($obj, array $post) {
    $types = explode(',', $post['types']);
    foreach ($types as $type_id) {
      if ($type_id == '') {
        continue;
      }
      $obj->addType($type_id);
    }
  }
  protected function extraEdit($obj, array $post) {
    $obj->resetTypes();
    $this->extraAdd($obj, $post);
  }
}
