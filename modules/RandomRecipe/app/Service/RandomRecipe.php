<?php
namespace App\Service;

use Psr\Container\ContainerInterface;
use Menu\Recipe;
use Menu\Category;

class RandomRecipe {
  protected $container;
  public function __construct(ContainerInterface $container) {
    $this->container = $container;
  }

  public function random(int $time = null) {
    $categories = $this->container->model->find(Category::class)
      ->select('categories.*')
      ->join([
        ['categories_times', 'categories_times.category_id', 'categories.id']
      ])
      ->where([
        'categories_times.time_id' => $time
      ])
      ->many();
    if ($time == null) {
      $categories = $this->container->model->find(Category::class)->many();
    }
    if (!$categories) {
      return false;
    }
    $recipes = [];
    foreach ($categories as $category) {
      if ($category->recipes()) {
        $recipes = array_merge($recipes, $category->recipes());
      }
    }
    if (count($recipes) == 0) {
      return false;
    }
    $i = mt_rand(0, count($recipes) - 1);
    return $recipes[$i];
  }
}
