<?php
namespace App\Service;

use Psr\Container\ContainerInterface;

class ModelMigrator {
  protected $data;
  protected $check;
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
      $data = $loader->load($file->getRealPath());
      $this->data[$file->getBasename('.' . $file->getExtension())] = $data;
    }
    return $this;
  }
  public function check() {
    foreach ($this->data as $i => $data) {
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
  public function migrate() {
    $output = [];
    foreach ($this->data as $i => $d) {
      if ($this->check[$i]) {
        continue;
      }
      $action = $d->action;
      switch (strtolower($action)) {
        case 'create':
          $output []= $this->create($d->data);
          break;
      }
    }
    return ['migrations' => $output];
  }
  protected function create($data) {
    /**
     * Default
     * table_name
     * column_definitions
     * table_options
     * partition_options
     */
    $table = $data->table;
    $query = ["CREATE TABLE IF NOT EXISTS", '`' . $table . '`'];
    $definitions = $this->parseDefinitions($data->definitions);
    $query []= $definitions;
    $partitions = [];
    $options = [];
    $query = implode(' ', $query);
    $result = \ORM::getDb()->exec($query);
    return ['action' => 'create', 'table' => $table, 'columns' => count($data->columns), 'result' => $result];
  }
  protected function parseDefinitions($data) {
    /**
     * Default $definitions
     * col_name column_definitions
     * | PRIMARY KEY (keys)
     * | FOREIGN KEY (key) REFERENCES <ref_table> (key) [ON DELETE {RESTRICT | CASCADE | SET NULL | NO ACTION | SET DEFAULT}] [ON UPDATE {}]
     * | [CONSTRAINT <symbol>] CHECK <expr> [[NOT] ENFORCED]
     * @var array
     */
    $definitions = [];
    foreach ($data->columns as $column) {
      $definitions []= $this->parseColumn($column);
    }
    if (isset($data->primary)) {
      $primary = [];
      $primary []= 'PRIMARY KEY';
      if (is_array($data->primary)) {
        $primary []= '(' . implode(', ', $data->primary) . ')';
      } else {
        $primary []= '(' . $data->primary . ')';
      }
      $definitions []= implode(' ', $primary);
    }
    if (isset($data->references)) {
      if (is_array($data->references)) {
        foreach ($data->references as $ref) {
          $foreign = ['FOREIGN KEY'];
          $foreign []= '(`' . $ref->local . '`)';
          $foreign []= $this->parseReference($ref);
          $definitions []= implode(' ', $foreign);
        }
      } else {
        $foreign = ['FOREIGN KEY'];
        $foreign []= '(`' . $data->references->local . '`)';
        $foreign []= $this->parseReference($data->references);
        $definitions []= implode(' ', $foreign);
      }
    }
    return '(' . implode(', ', $definitions) . ')';
  }
  protected function parseColumn($column) {
    if (is_array($column)) {
      $column = (object) $column;
    }
    /**
     * Default definitions
     * col_name data_type [NOT NULL | NULL] [DEFAULT <value>]
     * [AUTO_INCREMENT] [UNIQUE [KEY]] [[PRIMARY] KEY]
     * [COMMENT <comment>]
     * [COLLATE <collation>]
     * [COLUMN_FORMAT {FIXED | DYNAMIC | DEFAULT}]
     * [STORAGE {DISK | MEMORY}]
     * [REFERENCES <ref_table> (key) [ON DELETE {RESTRICT | CASCADE | SET NULL | NO ACTION | SET DEFAULT}] [ON UPDATE {}]]
     * [[CONSTRAINT <symbol>] CHECK <expr> [[NOT] ENFORCED]]
     *
     */
    $def = ['`' . $column->name . '`'];
    $def []= $this->parseColumnType($column->type);
    if (isset($column->null) and $column->null) {
      $def []= 'NULL';
    }
    if (isset($column->default)) {
      $def []= 'DEFAULT ' . $column->default;
    }
    if (isset($column->auto_increment) and $column->auto_increment) {
      $def []= 'AUTO_INCREMENT';
    }
    if (isset($column->unique) and $column->unique) {
      $def []= 'UNIQUE KEY';
    }
    if (isset($column->primary) and $column->primary) {
      $def []= 'PRIMARY KEY';
    }
    if (isset($column->references)) {
      $ref = $this->parseReference($column->references);
      $def []= $ref;
    }
    return implode(' ', $def);
  }
  protected function parseColumnType($type) {
    $def = [];
    $t = strtoupper($type->name);
    if (isset($type->length)) {
      $t .= '(' . $type->length . ')';
    }
    $def []= $t;
    if (isset($type->unsigned) and $type->unsigned) {
      $def []= 'UNSIGNED';
    }
    return implode(' ', $def);
  }
  protected function parseReference($data) {
    $ref = ['REFERENCES'];
    $ref []= '`' . $data->table . '`';
    if (is_array($data->keys)) {
      $ref []= '(`' . implode('`, `', $data->keys) . '`)';
    } else {
      $ref []= $data->keys;
    }
    if (isset($data->delete)) {
      $ref []= 'ON DELETE ' . strtoupper($data->delete);
    }
    if (isset($data->update)) {
      $ref []= 'ON UPDATE ' . strtoupper($data->update);
    }
    return implode(' ', $ref);
  }

  public function rollback() {
  }
}
