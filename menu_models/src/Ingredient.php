<?php
namespace Menu;

use App\Definition\Model;

/**
 * @property int $id
 * @property string $description
 */
class Ingredient extends Model {
  public static $_table = 'ingredients';

  public function types() {
    return $this->hasManyThrough(IngredientType::class, 'ingredients_types', 'ingredient_id', 'type_id')->findMany();
  }
  public function getTypes() {
    return $this->types();
  }
}
