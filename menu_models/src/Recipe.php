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
    return $this->container->cfg->get('configuration.alimenta');
  }
  protected $categories;
  public function categories(string $sort = '') {
    if ($this->categories == null) {
      $categories = $this->hasManyThrough(Category::class, 'recipes_categories', 'recipe_id', 'category_id');
      if ($sort != '') {
        $categories = $categories->sort('recipe_categories.' . $sort);
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
    $category = $this->container->model->find(Category::class)->one($category_id);
    $it = \ORM::for_table('recipes_categories')
      ->where('recipe_id', $this->id)
      ->where('category_id', $category->id)
      ->findOne();
    if ($it) {
      $it->delete();
    }
  }
  public function resetCategories() {
    foreach ($this->categories() as $category) {
      $this->removeCategory($category->id);
    }
  }

  protected $steps;
  public function steps() {
    if ($this->steps == null) {
      $steps = $this->hasMany(Step::class, 'recipe_id')->many();
      $this->steps = $steps;
    }
    return $this->steps;
  }
  public function addStep(array $data) {
    $data = [
      'recipe_id' => $this->id,
      'order' => ($this->steps()) ? count($this->steps()) + 1 : 1,
      'method_id' => $data['method_id']
    ];
    $step = $this->container->model->create(Step::class, $data);
    $step->save();
    $this->steps []= $step;
    return $step;
  }
  public function removeStep(int $step_id) {
    $query = 'DELETE FROM recipes_steps WHERE recipe_id = ? AND step_id = ?';
    $st = $this->container->pdo->prepare($query);
    $st->execute([
      $this->id,
      $step_id
    ]);
  }
  protected $ingredients;
  public function ingredients() {
    if ($this->ingredients == null) {
      $ingredients = $this->container->model->find(Ingredient::class)
        ->select(['ingredients.*', 'SUM(steps_ingredients.amount) as amount', 'steps_ingredients.unit_id'])
        ->join([
          ['steps_ingredients', 'steps_ingredients.ingredient_id', 'ingredients.id'],
          ['steps', 'steps_ingredients.step_id', 'steps.id']
        ])
        ->where(['steps.recipe_id' => $this->id])
        ->sort('steps.order')
        ->group(['ingredients.id', 'steps_ingredients.unit_id'])
        ->many();
      if (count($ingredients) == 1 and $ingredients[0]->id == null) {
        $ingredients = false;
      }
      array_walk($ingredients, function(&$item, $key, $container) {
        $item->unit = $container->model->find(Unit::class)->one($item->unit_id);
      }, $this->container);
      $this->ingredients = $ingredients;
    }
    return $this->ingredients;
  }

  public function __toArray(): array {
    $arr = parent::__toArray();
    if ($this->categories()) {
      $arr['categories'] = array_map(function($item) {
        return $item->__toArray();
      }, $this->categories());
    }
    if ($this->steps()) {
      $arr['steps'] = array_map(function($item) {
        return $item->__toArray();
      }, $this->steps());
    }
    return $arr;
  }
}
