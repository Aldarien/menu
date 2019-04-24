<?php
namespace Menu;

use App\Definition\Model;

/**
 * @property int $id
 * @property string $title
 * @property string $image
 */
class Recipe extends Model {
  public static $_table = 'recipes';

  public function steps() {
    return $this->hasManyThrough(Step::class, 'recipes_steps', 'recipe_id', 'step_id')->orderByAsc('recipes_steps.order')->findMany();
  }
  protected $ingredients;
  public function ingredients() {
    if ($this->ingredients == null) {
      $ingredients = $this->container->model->find(Ingredient::class)
        ->select(['ingredients.*'])
        ->select(['steps_ingredients.amount'])
        ->select(['units.*'])
        ->join([
          ['steps_ingredients', 'steps_ingredients.ingredient_id', 'ingredients.id'],
          ['recipes_steps', 'steps_ingredients.step_id', 'recipes_steps.step_id'],
          ['recipes', 'recipes_steps.recipe_id', 'recipes.id'],
          ['units', 'units.id', 'steps_ingredients.unit_id']
        ])
        ->many();
      $this->ingredients = $ingredients;
    }
    return $this->ingredients;
  }
}
