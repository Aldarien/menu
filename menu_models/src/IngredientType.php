<?php
namespace Menu;

use App\Definition\Model;

/**
 * @property int $id
 * @property string $description
 */
class IngredientType extends Model {
  public static $_table = 'ingredient_types';

  protected $ingredients;
  public function ingredients(string $sort = '') {
    if ($this->ingredients == null) {
      $ingredients = $this->hasManyThrough(Ingredient::class, 'ingredients_types', 'type_id', 'ingredient_id');
      if ($sort != '') {
        $ingredients = $ingredients->sort([$sort]);
      }
      $this->ingredients = $ingredients->many();
    }
    return $this->ingredients;
  }
  protected $has_ingredients = [];
  public function hasIngredient($ingredient) {
    if ($this->has_ingredients[$ingredient] == null) {
      $where = 'id';
      if (ctype_digit($ingredient)) {
        $where = 'description';
      }
      $ingredient = $this->hasManyThrough(Ingredient::class, 'ingredients_types', 'type_id', 'ingredient_id')
        ->where([
          'ingredients.' . $where => $ingredient
        ])
        ->one();
      $this->has_ingredients[$ingredient] = (!$ingredient) ? false : true;
    }
    return $this->has_ingredients[$ingredient];
  }
  public function addIngredient($ingredient_id) {
    $ingredient = $this->container->model->find(Ingredient::class)->one($ingredient_id);
    $it = \ORM::for_table('ingredients_types')
      ->where('ingredient_id', $ingredient->id)
      ->where('type_id', $this->id)
      ->findOne();
    if (!$it) {
      $query = "INSERT INTO ingredients_types (ingredient_id, type_id) VALUES (?, ?)";
      $st = $this->container->pdo->prepare($query);
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
