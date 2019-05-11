<?php
namespace Menu;

use Carbon\Carbon;
use App\Definition\Model;

/**
 * @property \DateTime $date
 * @property Recipe $recipe_id
 */
class Day extends Model {
  public static $_table = 'days';
  public static $_id_column = 'date';

  public function date(\DateTime $date = null) {
    if ($date == null) {
      return Carbon::parse($this->date, $this->container->cfg->get('app.timezone'));
    }
    $this->date = $date->format('Y-m-d');
  }
  protected $recipe;
  public function recipe() {
    if ($this->recipe == null) {
      $this->recipe = $this->container->model->find(Recipe::class)->one($this->recipe_id);
    }
    return $this->recipe;
  }

  public function __toArray(): array {
    $arr = parent::__toArray();
    $arr['recipe'] = $this->recipe()->__toArray();
    return $arr;
  }
}
