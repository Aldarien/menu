<?php
namespace Menu;

use App\Definition\Model;

/**
 * @property int $id
 * @property string $description
 */
class Category extends Model {
  public static $_table = 'categories';

  protected $recipes;
  public function recipes(string $sort = '') {
    if ($this->recipes == null) {
      $recipes = $this->hasManyThrough(Recipe::class, 'recipes_categories', 'category_id', 'recipe_id');
      if ($sort != '') {
        $recipes = $recipes->sort(['recipes.' . $sort]);
      }
      $recipes = $recipes->many();
      $this->recipes = $recipes;
    }
    return $this->recipes;
  }
  protected $times;
  public function times() {
    if ($this->times == null) {
      $times = $this->container->model->find(Time::class)
        ->select('times.*')
        ->join([
          ['categories_times', 'categories_times.time_id', 'times.id']
        ])
        ->where([
          'categories_times.category_id' => $this->id
        ])
        ->sort('times.id')
        ->many();
      $this->times = $times;
    }
    return $this->times;
  }
  protected $has_time;
  public function hasTime(int $time): bool {
    if (!isset($this->has_time[$time])) {
      if (!$this->times()) {
        $this->has_time[$time] = false;
        return $this->has_time[$time];
      }
      $this->has_time[$time] = true;
      if (array_search($time, array_map(function($item) {
        return $item->id;
      }, $this->times())) === false) {
        $this->has_time[$time] = false;
      }

    }
    return $this->has_time[$time];
  }
  public function addTime(int $time) {
    if (!$this->hasTime($time)) {
      $query = "INSERT INTO `categories_times` (`category_id`, `time_id`) VALUES (?, ?)";
      $st = $this->container->pdo->prepare($query);
      $st->execute([$this->id, $time]);
      $this->times []= $time;
      $this->has_time[$time] = true;
    }
  }
  public function removeTime(int $time) {
    if ($this->hasTime($time)) {
      $query = "DELETE FROM `categories_times` WHERE `category_id` = ? AND `time_id` = ?";
      $st = $this->container->pdo->prepare($query);
      $st->execute([$this->id, $time]);
      $i = array_search($time, $this->times);
      unset($this->times[$i]);
      $this->has_time[$time] = false;
    }
  }
  public function resetTimes() {
    if (!$this->times()) {
      return;
    }
    foreach ($this->times() as $time) {
      $this->removeTime($time);
    }
  }
}
