<?php
namespace Menu;

use App\Definition\Model;

/**
 * @property int $id
 * @property string $title
 * @property int $feeds
 * @property string $image
 */
class Recipe extends Model {
  public static $_table = 'recipes';

  public function feeds() {
    return $this->feeds * $this->container->cfg->get('configuration.alimenta');
  }
  protected $categories;
  public function categories(string $sort = '') {
    if ($this->categories == null) {
      $categories = $this->hasManyThrough(Category::class, 'recipes_categories', 'recipe_id', 'category_id');
      if ($sort != '') {
        $categories = $categories->sort(['recipe_categories.' . $sort]);
      }
      $this->categories = $categories->many();
    }
    return $this->categories;
  }
  protected $has_category = [];
  public function hasCategory($category) {
    if (!isset($this->has_category[$category])) {
      $where = 'id';
      if (!ctype_digit($category)) {
        $where = 'description';
      }
      $category = $this->hasManyThrough(Category::class, 'recipes_categories', 'recipe_id', 'category_id')
        ->where(['categories.' . $where, $category])->one();
      $this->has_category[$category] = (!$category) ? false : true;
    }
    return $this->has_category[$category];
  }
  public function addCategory(int $category_id) {
    $category = $this->container->model->find(Category::class)->one($category_id);
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
  public function removeCategory(int $category_id) {
    $category = $this->container->model->find(Category::class)->one($type_id);
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
      $steps = $this->hasManyThrough(Step::class, RecipesSteps::class, 'recipe_id', 'step_id')->many();
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
  public function removeStep(int $step_id) {
    $rs = $this->container->model->find(RecipesSteps::class)
      ->where([
        'recipe_id' => $this->id,
        'step_id' => $step_id
      ])
      ->one();
    $rs->delete();
  }
  protected $ingredients;
  public function ingredients() {
    if ($this->ingredients == null) {
      $ingredients = $this->container->model->find(Ingredient::class)
        ->select(['ingredients.*', 'SUM(steps_ingredients.amount) as amount'])
        ->join([
          ['steps_ingredients', 'steps_ingredients.ingredient_id', 'ingredients.id'],
          ['recipes_steps', 'steps_ingredients.step_id', 'recipes_steps.step_id']
        ])
        ->where(['recipes_steps.recipe_id' => $this->id])
        ->group('ingredients.id')
        ->many();
      if (count($ingredients) == 1 and $ingredients[0]->id == null) {
        $ingredients = false;
      }
      $this->ingredients = $ingredients;
    }
    return $this->ingredients;
  }

  public function __toArray(): array {
    $arr = parent::__toArray();
    $arr['categories'] = array_map(function($item) {
      return $item->__toArray();
    }, $this->categories);
    $arr['steps'] = array_map(function($item) {
      return $item->__toArray();
    }, $this->steps());
    return $arr;
  }
}
