<?php
namespace Menu;

use App\Definition\Model;

/**
 * @property int $id
 * @property string $description
 * @property Vessel $vessel_id
 */
class Method extends Model {
  public static $_table = 'methods';

  public function vessel() {
    return $this->belongsTo(Vessel::class, 'vessel_id')->one();
  }
  public function getVessel() {
    return $this->vessel();
  }

  public function __toArray(): array {
    $arr = parent::__toArray();
    $arr['vessel'] = $this->vessel()->__toArray();
    return $arr;
  }
}
