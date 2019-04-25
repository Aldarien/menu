<?php
namespace App\Service\Migrator;

class YMLMigrator implements MigratorInterface {
  public function load($filename) {
    $data = \yaml_parse_file($filename);
    $this->arrayToObject($data);
    return $data;
  }
  protected function arrayToObject(&$array) {
    if (is_array($array) and array_keys($array) !== range(0, count($array) - 1)) {
      $array = (object) $array;
    }
    foreach ($array as $key => $el) {
      if (is_array($el)) {
        if (array_keys($el) !== range(0, count($el) - 1)) {
          $el = (object) $el;
        }
        $el = $this->arrayToObject($el);
      }
      if (is_array($array)) {
        $array[$key] = $el;
      } else {
        $array->$key = $el;
      }
    }
    return $array;
  }
}
