<?php
namespace DBConfigLoader;

use App\Definition\DBLoader;

class SQLITELoader implements DBLoader {
  protected $config;
  protected $name;

  public function __construct($config, $name) {
    $this->config = $config;
    $this->name = $name;
  }
  public function load() {
    $dsn = 'sqlite:' . $this->config->get('databases.' . $this->name . '.filename');
    $name = ($this->name == 'default') ? \ORM::DEFAULT_CONNECTION : $this->name;
    \ORM::configure($dsn, null, $name);
  }
}
