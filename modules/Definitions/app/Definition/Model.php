<?php
namespace App\Definition;

use Psr\Container\ContainerInterface;

class Model extends \Model implements \JsonSerializable {
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
  public function __toArray(): array {
    return $this->asArray();
  }
  public function jsonSerialize() {
    return $this->__toArray();
  }
  public function belongsTo($model_class, $id = null) {
    $class = explode("\\", $model_class);
    $class = $class[count($class) - 1];
    $property = strtolower($class);
    $obj = $this->container->model->find($model_class);
    if ($id != null) {
      $id = 'id';
    }
    $obj = $obj->where([
      $id => $this->{$property . '_id'}
    ]);
    return $obj;
  }
  public function hasManyThrough($model_class, $table_through = null, $self_through_id = null, $model_through_id = null) {
    $self = $this->getTable();
    $model = (new $model_class())->getTable();
    if ($table_through == null) {
      $table_through = $self . '_' . $model;
    }
    if (class_exists($table_through)) {
      $table_through = (new $table_through())->getTable();
    }
    if ($self_through_id == null) {
      $self_through_id = $self . '_id';
    }
    if ($model_through_id == null) {
      $model_through_id = $model . '_id';
    }
    $objs = $this->container->model->find($model_class)
      ->join([
        [$table_through, $table_through . '.' . $model_through_id, $model . '.id']
      ])
      ->where([
        $table_through . '.' . $self_through_id => $this->id
      ]);
    return $objs;
  }
}
