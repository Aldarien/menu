<?php
namespace Menu;

use App\Definition\Model;

/**
 * @property int $id
 * @property string $description
 */
class RecipeCategory extends Model {
  public static $_table = 'recipe_categories';

  public function recipes() {
    return $this->hasManyThrough(Recipe::class, 'recipes_categories', 'category_id')->findOne();
  }
  public function getRecipes() {
    return $this->recipes();
  }
}
