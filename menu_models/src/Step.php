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
    return $this->belongsTo(Method::class, 'method_id')->findOne();
  }
  public function getMethod() {
    return $this->method();
  }
  public function addIngredient(array $data) {
    $data['step_id'] = $this->id;
    $si = $this->container->model->create(StepsIngredients::class, $data);
    $si->save();
  }
  protected $ingredients;
  public function ingredients() {
    if ($this->ingredients == null) {
      $ingredients = $this->container->model->find(Ingredient::class)
        ->select(['ingredients.*', 'steps_ingredients.amount'])
        ->join([
          ['steps_ingredients', 'steps_ingredients.ingredient_id', 'ingredients.id']
        ])
        ->where([
          'steps_ingredients.step_id' => $this->id
        ])
        ->many();
      $this->ingredients = $ingredients;
    }
    return $this->ingredients;
  }
  protected $recipes;
  public function recipes() {
    if ($this->recipes == null) {
      $recipes = $this->container->model->find(Recipe::class)
        ->select('recipes.*')
        ->join([
          ['recipes_steps', 'recipes_steps.recipe_id', 'recipes.id']
        ])
        ->where([
          'recipes_steps.step_id' => $this->id
        ])
        ->many();
      $this->recipes = $recipes;
    }
    return $recipes;
  }
  /*public function recipesSteps() {
    return $this->hasMany(RecipesSteps::class, 'step_id')->findMany();
  }*/
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

  public function getIngredients() {
    return $this->ingredients();
  }
}
