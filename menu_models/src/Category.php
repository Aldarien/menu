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
      $recipes = $recipes->one();
      $this->recipes = $recipes;
    }
    return $this->recipes;
  }
}
