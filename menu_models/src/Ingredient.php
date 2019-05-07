<?php
namespace Menu;

use App\Definition\Model;

/**
 * @property int $id
 * @property string $description
 */
class Ingredient extends Model {
  public static $_table = 'ingredients';

  protected $types;
  public function types(string $sort = '') {
    if ($this->types == null) {
      $types = $this->container->model->find(IngredientType::class)
        ->select('ingredient_types.*')
        ->join([
          ['ingredients_types', 'ingredients_types.type_id', 'ingredient_types.id']
        ])
        ->where([
          'ingredients_types.ingredient_id' => $this->id
        ]);
        if ($sort != '') {
          $types = $types->sort([$sort]);
        }
        $this->types = $types->many();
    }
    return $this->types;
  }
  protected $has_types = [];
  public function hasType($type) {
    if (!isset($this->has_types[$type])) {
      $type = $this->container->model->find(IngredientType::class)
        ->select('1')
        ->join([
          ['ingredients_types', 'ingredients_types.type_id', 'ingredient_types.id']
        ]);
      if (ctype_digit($type)) {
        $type = $type->where(['ingredient_types.id', $type]);
      } else {
        $type = $type->where(['ingredient_types.description', $type]);
      }
      $type = $type->one();
      $this->has_types[$type] = (!$type) ? false : true;
    }
    return $this->has_types[$type];
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
    $this->types []= $type;
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
  protected $unit;
  public function unit($recipe) {
    if ($this->unit == null) {
      $unit = $this->container->model->find(Unit::class)
        ->select(['units.*'])
        ->join([
          ['steps_ingredients', 'steps_ingredients.unit_id', 'units.id'],
          ['recipes_steps', 'recipes_steps.step_id', 'steps_ingredients.step_id']
        ])
        ->where([
          'steps_ingredients.ingredient_id' => $this->id,
          'recipes_steps.recipe_id' => $recipe->id
        ])
        ->one();
      $this->unit = $unit;
    }
    return $this->unit;
  }
}
