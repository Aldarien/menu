<?php
namespace Menu;

use App\Definition\Model;

/**
 * @property int $id
 * @property string $description
 */
class Ingredient extends Model {
  public static $_table = 'ingredients';

  public function types(string $sort = '') {
    if ($sort == '') {
      return $this->hasManyThrough(IngredientType::class, 'ingredients_types', 'ingredient_id', 'type_id')->findMany();
    }
    return $this->hasManyThrough(IngredientType::class, 'ingredients_types', 'ingredient_id', 'type_id')->orderByAsc($sort)->findMany();
  }
  public function hasType($type) {
    if (ctype_digit($type)) {
      $type = $this->hasManyThrough(IngredientType::class, 'ingredients_types', 'ingredient_id', 'type_id')->where('id', $type)->findOne();
    } else {
      $type = $this->hasManyThrough(IngredientType::class, 'ingredients_types', 'ingredient_id', 'type_id')->where('description', $type)->findOne();
    }
    if (!$type) {
      return false;
    }
    return true;
  }
  public function getTypes() {
    return $this->types();
  }
  public function addType($type_id) {
    $type = $this->container->model->find(IngredientType::class)->one($type_id);
    $it = \ORM::for_table('ingredients_types')
      ->where('ingredient_id', $this->id)
      ->where('type_id', $type->id)
      ->findOne();
    if (!$it) {
      $query = "INSERT INTO ingredients_types (ingredient_id, type_id) VALUES (?, ?)";
      $st = \ORM::getDb()->prepare($query);
      $st->execute([$this->id, $type->id]);
    }
  }
  public function removeType($type_id) {
    $type = $this->container->model->find(IngredientType::class)->one($type_id);
    $it = \ORM::for_table('ingredients_types')
      ->where('ingredient_id', $this->id)
      ->where('type_id', $type->id)
      ->findOne();
    if ($it) {
      $it->delete();
    }
  }
}
