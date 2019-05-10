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
      $types = $this->hasManyThrough(IngredientType::class, 'ingredients_types', 'ingredient_id', 'type_id');
      if ($sort != '') {
        $types = $types->sort([$sort]);
      }
      $types = $types->many();
      $this->types = $types;
    }
    return $this->types;
  }
  protected $has_types = [];
  public function hasType($type) {
    if (!isset($this->has_types[$type])) {
      $where = 'id';
      if (!ctype_digit($type)) {
        $where = 'description';
      }
      $t = $this->container->model->find(IngredientType::class)
        ->join([
          ['ingredients_types', 'ingredients_types.type_id', 'ingredient_types.id']
        ])
        ->where(['ingredient_type.' . $where => $type])
        ->one();
      $this->has_types[$type] = (!$t) ? false : true;
    }
    return $this->has_types[$type];
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
    $query = "DELETE FROM ingredients_types WHERE ingredient_id = ? AND type_id = ?";
    $st = \ORM::getDb()->prepare($query);
    $st->execute([
      $this->id,
      $type->id
    ]);
  }
  public function resetTypes() {
    foreach ($this->types() as $type) {
      $this->removeType($type->id);
    }
  }

  protected $unit;
  public function unit(Recipe $recipe) {
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
  protected $amount;
  public function amount($reference) {
    if ($this->amount == null) {
      $is = $this->container->model->find(StepsIngredients::class)
        ->select('SUM(steps_ingredients.amount) / recipes.feeds as amount')
        ->join([
          ['recipes_steps', 'recipes_steps.step_id', 'steps_ingredients.step_id'],
          ['recipes', 'recipes.id', 'recipes_steps.recipe_id']
        ])
        ->where([
          'steps_ingredients.ingredient_id' => $this->id,
          'recipes_steps.recipe_id' => $reference->id
        ])
        ->group('recipes_steps.recipe_id')
        ->one();
      $amount = $is->amount;
      $this->amount = $amount;
    }
    return $this->amount * $this->container->cfg->get('configuration.alimenta');
  }

  protected $recipes;
  public function recipes() {
    if ($this->recipes == null) {
      $recipes = $this->container->model->find(Recipe::class)
        ->select('recipes.*')
        ->join([
          ['recipes_steps', 'recipes_steps.recipe_id', 'recipes.id'],
          ['steps_ingredients', 'steps_ingredients.step_id', 'recipes_steps.step_id']
        ])
        ->where([
          'steps_ingredients.ingredient_id' => $this->id
        ])
        ->many();
      $this->recipes = $recipes;
    }
    return $this->recipes;
  }

  public function __toArray(): array {
    $arr = parent::__toArray();
    if ($this->types()) {
      $arr['types'] = array_map(function($item) {
        return $item->__toArray();
      }, $this->types());
    }
    return $arr;
  }
}
