<?php
namespace App\Definition;

use Psr\Container\ContainerInterface;

class Model extends \Model {
  protected $container;
  public function setContainer(ContainerInterface $container) {
    $this->container = $container;
  }
  public static function getTable() {
    return self::_get_table_name(get_called_class());
  }
  public function save() {
    $pdo = \ORM::getDb();
    $pdo->beginTransaction();
    try {
      parent::save();
      $pdo->commit();
    } catch (\Exception $e) {
      $pdo->rollBack();
      throw $e;
    }
  }
}
