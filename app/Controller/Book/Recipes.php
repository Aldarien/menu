<?php
namespace App\Controller\Book;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Menu\Recipe;

class Recipes extends Base {
  public function __construct(ContainerInterface $container) {
    parent::__construct($container);
    $this->singular = 'recipe';
    $this->plural = 'recipes';
    $this->model = Recipe::class;
    $this->sort = 'title';
    $this->columns = ['title', 'image', 'feeds'];
  }

  protected function extraAdd($obj, array $post) {
    $categories = explode(',', $post['categories']);
    foreach ($categories as $category_id) {
      if ($category_id == '') {
        continue;
      }
      $obj->addCategory($category_id);
    }
  }
  protected function extraEdit($obj, array $post) {
    $obj->resetCategories();
    $this->extraAdd($obj, $post);
  }
}
