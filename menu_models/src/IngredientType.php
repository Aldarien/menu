<?php
namespace Menu;

use App\Definition\Model;

/**
 * @property int $id
 * @property string $description
 */
class IngredientType extends Model {
  public static $_table = 'ingredient_types';

  public function ingredients() {
    return $this->hasManyThrough(Ingredient::class, 'ingredients_types', 'type_id', 'ingredient_id')->findMany();
  }
}
