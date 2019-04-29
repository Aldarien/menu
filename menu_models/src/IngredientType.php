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
  public function hasIngredient($ingredient) {
    if (ctype_digit($ingredient)) {
      $ingredient = $this->hasManyThrough(Ingredient::class, 'ingredients_types', 'type_id', 'ingredient_id')->where('id', $ingredient)->findOne();
    } else {
      $ingredient = $this->hasManyThrough(Ingredient::class, 'ingredients_types', 'type_id', 'ingredient_id')->where('description', $ingredient)->findOne();
    }
    if (!$ingredient) {
      return false;
    }
    return true;
  }
  public function addIngredient($ingredient_id) {
    $ingredient = $this->container->model->find(Ingredient::class)->one($ingredient_id);
    $it = \ORM::for_table('ingredients_types')
      ->where('ingredient_id', $ingredient->id)
      ->where('type_id', $this->id)
      ->findOne();
    if (!$it) {
      $query = "INSERT INTO ingredients_types (ingredient_id, type_id) VALUES (?, ?)";
      $st = \ORM::getDb()->prepare($query);
      $st->execute([$ingredient->id, $this->id]);
    }
  }
  public function removeIngredient($ingredient_id) {
    $ingredient = $this->container->model->find(Ingredient::class)->one($ingredient_id);
    $it = \ORM::for_table('ingredients_types')
      ->where('ingredient_id', $ingredient->id)
      ->where('type_id', $this->id)
      ->findOne();
    if ($it) {
      $it->delete();
    }
  }
}
