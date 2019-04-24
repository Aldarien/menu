<?php
namespace Menu;

use App\Definition\Model;

/**
 * @property int $int
 * @property string $description
 * @property string $abreviation
 */
class Unit extends Model {
  public static $_table = 'units';
}
