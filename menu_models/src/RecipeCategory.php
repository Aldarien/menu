<?php
namespace Menu;

use App\Definition\Model;

/**
 * @property int $id
 * @property string $description
 */
class RecipeCategory extends Model {
  public static $_table = 'recipe_categories';

  public function recipes(string $sort = '') {
    if ($sort == '') {
      return $this->hasManyThrough(Recipe::class, 'recipes_categories', 'category_id', 'recipe_id')->findOne();
    }
    return $this->hasManyThrough(Recipe::class, 'recipes_categories', 'category_id', 'recipe_id')->orderByAsc('recipes.' . $sort)->findOne();
  }
  public function getRecipes() {
    return $this->recipes();
  }
}
