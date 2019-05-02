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
  protected $order;
  public function order(Recipe $recipe) {
    if ($this->order == null) {
      $data =\ORM::for_table('recipes_steps')
        ->select('order')
        ->where('step_id', $this->id)
        ->where('recipe_id', $recipe->id)
        ->findOne();
      $this->order = $data['order'];
    }
    return $this->order;
  }

  public function getIngredients() {
    return $this->ingredients();
  }
}
