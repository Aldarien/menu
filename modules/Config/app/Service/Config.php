<?php
namespace App\Service;

use Config\Config as CModel;

class Config {
  protected $data;

  public function __construct($config_folder = null) {
    if ($config_folder == null) {
      $config_folder = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'config';
    }
    $this->data = (object) [];
    $this->load($config_folder);
  }

  protected function load($folder) {
    $files = new \DirectoryIterator($folder);
    foreach ($files as $file) {
      if ($file->isDir()) {
        continue;
      }
      $loader = implode("\\", ["Loader", str_replace('YML', 'YAML', strtoupper($file->getExtension()) . 'Loader')]);
      if (!class_exists($loader)) {
        continue;
      }
      $loader = new $loader($folder . DIRECTORY_SEPARATOR . $file->getFilename());
      $this->data->{$loader->getName()} = $loader->load();
    }
  }
  public function dbload($container) {
    $configs = $container->model->find(CModel::class)->many();
    if (!$config) {
      return $this;
    }
    $this->data['configuration'] = [];
    foreach ($configs as $config) {
      $name = str_replace(' ', '', strtolower($config->description));
      $this->data['configuration'][$name] = $config->value;
    }
  }
  public function get($name, $current = null, $full = '') {
    if ($current == null) {
      $current = $this->data;
      $full = $name;
    }
    if (is_array($current)) {
      $current = (object) $current;
    }
    $name = explode('.', $name);
    if (count($name) > 1) {
      $f = array_shift($name);
      if (!isset($current->$f)) {
        throw new \InvalidArgumentException($f . ' not found.');
      }
      return $this->get(implode('.', $name), $current->$f, $full);
    }
    if (!isset($current->{$name[0]})) {
      return null;
    }
    $output = $current->{$name[0]};
    $clean = $this->clean($output);
    if ($clean != $output) {
      $this->set($full, $clean);
    }
    return $clean;
  }
  public function set($name, $value) {
    $name = "->" . implode("->", explode('.', $name));
    $str = "\$this->data{$name} = \$value;";
    eval($str);
  }
  protected function clean($value) {
    if (!is_string($value)) {
      return $value;
    }
    if (strpos($value, '{') !== false) {
      $output = [];
      $str = "/\{(.*)\}/";
      preg_match_all($str, $value, $output, \PREG_SET_ORDER);
      foreach ($output as $d) {
        $value = str_replace($d[0], $this->get($d[1]), $value);
      }
      return $value;
    }
    if (strpos($value, '(') !== false) {
      $str = "\$output = " . $value . ';';
      eval($str);
      return $output;
    }
    return $value;
  }
}
