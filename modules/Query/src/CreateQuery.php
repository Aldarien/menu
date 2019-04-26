<?php
namespace Query;

use App\Definition\QueryInterface;

class CreateQuery implements QueryInterface {
  protected $query;
  protected $table;
  /**
   * Definitions
   *  @property array $columns
   *  [@property string $primary]
   *  [@property array $references]
   *  [@property array $constraints]
   * @var [object]
   */
  protected $definitions;
  /**
   * Options
   *  Not implemented
   * @var [object]
   */
  protected $options;
  /**
   * Partitions
   *  Not implemented
   * @var [object]
   */
  protected $partitions;

  public function parseData($data): QueryInterface {
    /**
     * Default
     * table_name
     * column_definitions
     * table_options
     * partition_options
     */
    $this->setTable($data->table);
    $this->setDefinitions($data->definitions);
    return $this;
  }
  public function setTable(string $table): QueryInterface {
    $this->table = $table;
    return $this;
  }
  public function setDefinitions(object $definitions): QueryInterface {
    $this->definitions = $definitions;
    return $this;
  }

  public function build(): QueryInterface {
    $query = ["CREATE TABLE IF NOT EXISTS", '`' . $this->table . '`'];
    $definitions = $this->parseDefinitions();
    $query []= $definitions;
    $this->partitions = [];
    $this->options = [];
    $this->query = implode(' ', $query);
    return $this;
  }
  public function execute(): array {
    $result = \ORM::getDb()->exec($this->query);
    return ['action' => 'create', 'table' => $this->table, 'columns' => count($this->definitions->columns), 'result' => $result];
  }

  protected function parseDefinitions() {
    $data = $this->definitions;
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
      $ref []= '(`' . $data->keys . '`)';
    }
    if (isset($data->delete)) {
      $ref []= 'ON DELETE ' . strtoupper($data->delete);
    }
    if (isset($data->update)) {
      $ref []= 'ON UPDATE ' . strtoupper($data->update);
    }
    return implode(' ', $ref);
  }
}
