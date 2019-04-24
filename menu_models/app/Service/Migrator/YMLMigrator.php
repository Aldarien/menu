<?php
namespace App\Service\Migrator;

class YMLMigrator implements MigratorInterface {
  protected $data;
  public function load($filename): MigratorInterface {
    $this->data = \yaml_parse(trim(file_get_contents($filename)));
    return $this;
  }
  public function migrate() {
    !d($this->data);
    $action = $this->data->action;
  }
}
