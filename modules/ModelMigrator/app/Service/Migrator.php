<?php
namespace App\Service;

use Psr\Container\ContainerInterface;

class Migrator {
  protected $data;
  protected $check;
  protected $container;

  public function __construct(ContainerInterface $container) {
    $this->container = $container;
  }

  public function load(string $migrations) {
    $dir = new \DirectoryIterator($migrations);
    $models = [];
    foreach ($dir as $file) {
      if ($file->isDir()) {
        continue;
      }
      $class = implode("\\", ['Loader', str_replace('YML', 'YAML', strtoupper($file->getExtension()) . 'Loader')]);
      if (!class_exists($class)) {
        continue;
      }
      $loader = new $class($file->getRealPath());
      $data = $loader->load();
      $this->data[$file->getBasename('.' . $file->getExtension())] = $data;
    }
    return $this;
  }
  public function check() {
    foreach ($this->data as $i => $data) {
      $method = 'check' . ucfirst(strtolower($data->action));
      if (!method_exists($this, $method)) {
        continue;
      }
      $this->check[$i] = $this->{$method}($data->data);
      switch (strtolower($data->action)) {
        case 'create':
          $this->check[$i] = $this->checkCreate($data->data);
        break;
      }
    }
    return $this;
  }
  protected function checkCreate($data) {
    $query = "SHOW TABLES LIKE '{$data->table}'";
    $result = \ORM::getDb()->query($query);
    if ($result->rowCount() == 1) {
      return true;
    }
    return false;
  }
  protected function checkInsert($data) {
    $query = "SELECT " . implode(', ', $data->columns) . " FROM " . $data->table . " WHERE ";
    $arr = [];
    foreach ($data->values as $values) {
      foreach ($values as $i => $val) {
        if (!isset($arr[$data->columns[$i]])) {
          $arr[$data->columns[$i]] = [];
        }
        if (is_string($val)) {
          $val = "'" . $val . "'";
        }
        $arr[$data->columns[$i]] []= $val;
      }
    }
    array_walk($arr, function(&$item, $key) {
      $item = $key . ' IN (' . implode(', ', $item) . ')';
    });
    $query .= implode(' AND ', $arr);
    $st = \ORM::getDb()->query($query);
    if ($st->rowCount() > 0) {
      return true;
    }
    return false;
  }
  public function migrate() {
    $output = [];
    foreach ($this->data as $i => $d) {
      if (isset($this->check[$i]) and $this->check[$i]) {
        continue;
      }
      $action = $d->action;
      $query = new Query($action);
      $output []= $query->run($d->data);
    }
    return ['migrations' => $output];
  }

  public function rollback() {
    $exchanges = ['create' => 'drop', 'insert' => 'delete'];
    $exchanges = array_merge($exchanges, array_flip($exchanges));
    $output = [];
    foreach ($this->data as $i => $d) {
      $action = $exchanges[strtolower($d->action)];
      $query = new Query($action);
      $output []= $query->run($d->data);
    }
    return ['rollbacks' => $output];
  }
}
