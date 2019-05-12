<?php
namespace Menu;

use App\Definition\Model;

/**
 * @property int $id
 * @property Method $method_id
 */
class Step extends Model {
  public static $_table = 'steps';

  public function method() {
    return $this->belongsTo(Method::class, 'method_id')->one();
  }
  public function addIngredient(array $data) {
    $data['step_id'] = $this->id;
    $si = $this->container->model->create(StepsIngredients::class, $data);
    $si->save();
  }
  protected $ingredients;
  public function ingredients() {
    if ($this->ingredients == null) {
      $ingredients = $this->hasManyThrough(Ingredient::class, 'steps_ingredients', 'step_id', 'ingredient_id')
        ->select(['ingredients.*', 'steps_ingredients.amount'])
        ->many();
      $this->ingredients = $ingredients;
    }
    return $this->ingredients;
  }
  protected $recipes;
  public function recipes() {
    if ($this->recipes == null) {
      $recipes = $this->hasManyThrough(Recipe::class, RecipesSteps::class, 'recipe_id', 'step_id')->many();
      $this->recipes = $recipes;
    }
    return $recipes;
  }
  protected $order;
  public function order(Recipe $recipe) {
    if ($this->order == null) {
      $rs = $this->container->model->find(RecipesSteps::class)
        ->select('order')
        ->where([
          'step_id' => $this->id,
          'recipe_id' => $recipe->id
        ])
        ->one();
      $this->order = $rs->order;
    }
    return $this->order;
  }

  public function __toArray(): array {
    $arr = parent::__toArray();
    $arr['method'] = $this->method()->__toArray();
    $arr['ingredients'] = array_map(function($item) {
      return $item->__toArray();
    }, $this->ingredients());
    return $arr;
  }
}
