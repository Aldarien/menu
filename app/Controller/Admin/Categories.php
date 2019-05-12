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

  public function extraAdd($obj, array $post) {
    $times = explode(',', $post['times']);
    foreach ($times as $time) {
      if ($time == '') {
        continue;
      }
      $obj->addTime($time);
    }
  }
  public function extraEdit($obj, array $post) {
    $obj->resetTimes();
    $this->extraAdd($obj, $post);
  }
}
