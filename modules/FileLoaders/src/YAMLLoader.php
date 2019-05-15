<?php
namespace FileLoaders;

use \Spyc;
use App\Definition\FileLoader;

class YAMLLoader implements FileLoader {
  protected $name;
  protected $filename;

  public function __construct(string $filename) {
    $this->filename = $filename;
    $info = new \SplFileInfo($this->filename);
    $this->name = $info->getBasename('.' . $info->getExtension());
  }
  public function load() {
    //$data = \yaml_parse_file($filename);
    $data = Spyc::YAMLLoad($this->filename);
    $this->arrayToObject($data);
    return $data;
  }
  public function getName() {
    return $this->name;
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
