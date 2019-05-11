<?php
namespace Menu;

use App\Definition\Model;

/**
 * @property Recipe $recipe_id
 * @property Step $step_id
 * @property int $order
 */
class RecipesSteps extends Model {
  public static $_table = 'recipes_steps';

  public function recipe() {
    return $this->belongsTo(Recipe::class, 'recipe_id')->one();
  }
  public function step() {
    return $this->belongsTo(Step::class, 'step_id')->one();
  }
}
