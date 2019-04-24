<?php
namespace App\Service;

use Psr\Container\ContainerInterface;

class ModelMigrator {
  protected $container;

  public function __construct(ContainerInterface $container) {
    $this->container = $container;
  }

  public function load() {
    $dir = new \DirectoryIterator(implode(DIRECTORY_SEPARATOR, [dirname(dirname(__DIR__)), 'resources', 'migrations']));
    $models = [];
    foreach ($dir as $file) {
      if ($file->isDir()) {
        continue;
      }
      $class = implode("\\", ['App', 'Service', 'Migrator', strtoupper($file->getExtension()) . 'Migrator']);
      $loader = new $class;
      $loader->load($file->getRealPath())->migrate();
    }
    return $this;
  }
  public function create() {
    /*foreach ($this->models as $model) {
      $ref = new \ReflectionClass($model);
      $docs = $ref->getDocComment();
      $table = $ref->getProperty('_table')->getValue();
      !d($table, $docs);
    }*/
  }
}
