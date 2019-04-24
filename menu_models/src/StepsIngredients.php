<?php
namespace Menu;

use App\Definition\Model;

/**
 * @property int $id
 * @property Step $step_id
 * @property Ingredient $ingredient_id
 * @property int $amount
 * @property Unit $unit_id
 */
class StepsIngredients extends Model {
  public static $_table = 'steps_ingredients';

  public function step() {
    return $this->belongsTo(Step::class, 'step_id')->findOne();
  }
  public function ingredient() {
    return $this->belongsTo(Ingredient::class, 'ingredient_id')->findOne();
  }
}
