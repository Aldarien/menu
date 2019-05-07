<?php
namespace Menu;

use App\Definition\Model;

/**
 * @property int $id
 * @property string $title
 * @property string $image
 */
class Recipe extends Model {
  public static $_table = 'recipes';

  public function categories(string $sort = '') {
    if ($sort == '') {
      return $this->hasManyThrough(RecipeCategory::class, 'recipes_categories', 'recipe_id', 'category_id')->findMany();
    }
    return $this->hasManyThrough(RecipeCategory::class, 'recipes_categories', 'recipe_id', 'category_id')->orderByAsc('recipe_categories.' . $sort)->findMany();
  }
  public function hasCategory($category) {
    if (ctype_digit($category)) {
      $category = $this->hasManyThrough(RecipeCategory::class, 'recipes_categories', 'recipe_id', 'category_id')->where('categories.id', $category)->findOne();
    } else {
      $category = $this->hasManyThrough(IngredientType::class, 'ingredients_types', 'ingredient_id', 'type_id')->where('categories.description', $category)->findOne();
    }
    if (!$category) {
      return false;
    }
    return true;
  }
  public function addCategory($category_id) {
    $category = $this->container->model->find(RecipeCategory::class)->one($category_id);
    $rc = \ORM::for_table('recipes_categories')
      ->where('recipe_id', $this->id)
      ->where('category_id', $category->id)
      ->findOne();
    if (!$rc) {
      $query = "INSERT INTO recipes_categories (recipe_id, category_id) VALUES (?, ?)";
      $st = \ORM::getDb()->prepare($query);
      $st->execute([$this->id, $category->id]);
    }
  }
  public function removeCategory($category_id) {
    $category = $this->container->model->find(RecipeCategory::class)->one($type_id);
    $it = \ORM::for_table('recipes_categories')
      ->where('recipe_id', $this->id)
      ->where('category_id', $category->id)
      ->findOne();
    if ($it) {
      $it->delete();
    }
  }
  protected $steps;
  public function steps() {
    if ($this->steps == null) {
      $steps = $this->container->model->find(Step::class)
        ->select('steps.*')
        ->join([
          ['recipes_steps', 'recipe_id', 'step_id']
        ])
        ->where([
          'recipes_steps.recipe_id' => $this->id
        ])
        ->many();
      $this->steps = $steps;
    }
    return $this->steps;
  }
  public function addStep(array $data) {
    $step = $this->container->model->create(Step::class, $data);
    $step->save();
    $data = [
      'recipe_id' => $this->id,
      'step_id' => $step->id,
      'order' => count($this->steps())
    ];
    $rs = $this->container->model->create(RecipesSteps::class, $data);
    $rs->save();
    $this->steps []= $step;
    return $step;
  }
  protected $ingredients;
  public function ingredients() {
    if ($this->ingredients == null) {
      $ingredients = $this->container->model->find(Ingredient::class)
        ->select(['ingredients.*', 'steps_ingredients.amount'])
        ->join([
          ['steps_ingredients', 'steps_ingredients.ingredient_id', 'ingredients.id'],
          ['recipes_steps', 'steps_ingredients.step_id', 'recipes_steps.step_id']
        ])
        ->where(['recipes_steps.recipe_id' => $this->id])
        ->many();
      $this->ingredients = $ingredients;
    }
    return $this->ingredients;
  }
}
