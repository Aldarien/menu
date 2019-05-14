<?php
namespace DBConfigLoader;

use App\Definition\DBLoader;

class MYSQLLoader implements DBLoader {
  protected $config;
  protected $name;

  public function __construct($config, $name) {
    $this->config = $config;
    $this->name = $name;
  }
  public function load() {
    $dsn = ['mysql:host=' . $this->config->get('databases.' . $this->name . '.host')];
    if ($this->config->get('databases.' . $this->name . '.port') !== null) {
      $dsn []= 'port=' . $this->config->get('databases.' . $this->name . '.port');
    }
    $dsn []= 'dbname=' . $this->config->get('databases.' . $this->name . '.name');
    $dsn = implode(';', $dsn);

    $name = ($this->name == 'default') ? \ORM::DEFAULT_CONNECTION : $this->name;

    \ORM::configure($dsn, null, $name);
    \ORM::configure('username', $this->config->get('databases.' . $this->name . '.user.name'), $name);
    \ORM::configure('password', $this->config->get('databases.' . $this->name . '.user.password'), $name);
    \ORM::configure('driver_options', array(\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'), $name);
  }
}
