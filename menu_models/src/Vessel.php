<?php
namespace Menu;

use App\Definition\Model;

/**
 * @property int $id
 * @property string $description
 */
class Vessel extends Model {
  public static $_table = 'vessels';

  protected $methods;
  public function methods() {
    if ($this->methods == null) {
      $methods = $this->hasMany(Method::class, 'vessel_id')->findMany();
      $this->methods = $methods;
    }
    return $this->methods;
  }
}
