<?php
namespace Menu;

use App\Definition\Model;

/**
 * @property int $id
 * @property string $method
 */
class Step extends Model {
  public static $_table = 'steps';

  public function ingredients() {
    return $this->hasManyThrough(Ingredient::class, 'steps_ingredients', 'step_id', 'ingredient_id')->findMany();
  }
  public function recipes() {
    return $this->hasManyThrough(Recipe::class, 'recipes_steps', 'step_id', 'recipe_id')->findMany();
  }
  public function recipesSteps() {
    return $this->hasMany(RecipesSteps::class, 'step_id')->findMany();
  }

  public function getIngredients() {
    return $this->ingredients();
  }
}
