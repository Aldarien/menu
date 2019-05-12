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
      $st = $this->container->pdo->prepare($query);
      $st->execute([$this->id, $type->id]);
    }
    $this->types []= $type;
  }
  public function removeType($type_id) {
    $type = $this->container->model->find(IngredientType::class)->one($type_id);
    $query = "DELETE FROM ingredients_types WHERE ingredient_id = ? AND type_id = ?";
    $st = $this->container->pdo->prepare($query);
    $st->execute([
      $this->id,
      $type->id
    ]);
  }
  public function resetTypes() {
    if (!$this->types()) {
      return;
    }
    foreach ($this->types() as $type) {
      $this->removeType($type->id);
    }
  }

  protected $unit;
  public function unit($reference) {
    $class = get_class($reference);
    if ($this->unit[$class] == null) {
      switch ($class) {
        case Recipe::class:
          $unit = $this->container->model->find(Unit::class)
            ->select(['units.*'])
            ->join([
              ['steps_ingredients', 'steps_ingredients.unit_id', 'units.id'],
              ['steps', 'steps.id', 'steps_ingredients.step_id']
            ])
            ->where([
              'steps_ingredients.ingredient_id' => $this->id,
              'steps.recipe_id' => $reference->id
            ])
            ->one();
          break;
        case Step::class:
          $unit = $this->container->model->find(Unit::class)
            ->select(['units.*'])
            ->join([
              ['steps_ingredients', 'steps_ingredients.unit_id', 'units.id'],
              ['steps', 'steps.id', 'steps_ingredients.step_id']
            ])
            ->where([
              'steps_ingredients.ingredient_id' => $this->id,
              'steps.id' => $reference->id
            ])
            ->one();
          break;
      }
      $this->unit[$class] = $unit;
    }
    return $this->unit[$class];
  }
  protected $amount;
  public function amount($reference) {
    if ($this->amount == null) {
      if (is_a($reference, Recipe::class)) {
        $is = $this->container->model->find(StepsIngredients::class)
          ->select('SUM(steps_ingredients.amount) / recipes.feeds as amount')
          ->join([
            ['steps', 'steps.id', 'steps_ingredients.step_id'],
            ['recipes', 'recipes.id', 'steps.recipe_id']
          ])
          ->where([
            'steps_ingredients.ingredient_id' => $this->id,
            'steps.recipe_id' => $reference->id
          ])
          ->group('steps.recipe_id')
          ->one();
        $amount = $is->amount;
      } else {
        $is = $this->container->model->find(StepsIngredients::class)
          ->select('(steps_ingredients.amount / recipes.feeds) as amount')
          ->join([
            ['steps', 'steps.id', 'steps_ingredients.step_id'],
            ['recipes', 'recipes.id', 'steps.recipe_id']
          ])
          ->where([
            'steps_ingredients.ingredient_id' => $this->id,
            'steps.id' => $reference->id
          ])
          ->group('steps.id')
          ->one();
        $amount = $is->amount;
      }
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
          ['steps', 'steps.recipe_id', 'recipes.id'],
          ['steps_ingredients', 'steps_ingredients.step_id', 'steps.id']
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
