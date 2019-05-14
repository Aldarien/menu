<?php
namespace App\Service;

class DBConfigLoader {
  protected $config;

  public function __construct($config) {
    $this->config = $config;
  }
  public function load() {
    foreach ($this->config->get('databases') as $name => $config) {
      $loader_class = ['DBConfigLoader', strtoupper($config->engine) . 'Loader'];
      $loader_class = implode("\\", $loader_class);
      if (class_exists($loader_class)) {
        $loader = new $loader_class($this->config, $name);
        $loader->load();
      }
    }
    return $this;
  }
  public function shortTables() {
    \Model::$short_table_names = true;
    return $this;
  }
}
