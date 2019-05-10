<?php
namespace Config;

use App\Definition\Model;

/**
 * @property int $id
 * @property string $description
 * @property string $value
 */
class Config extends Model {
  public static $_table = 'configs';
}
