<?php
namespace App\Definition;

use Psr\Container\ContainerInterface;

class Model extends \Model {
  protected $container;
  public function setContainer(ContainerInterface $container) {
    $this->container = $container;
  }
  public static function getTable() {
    return self::__get_table_name(get_called_class());
  }
}
