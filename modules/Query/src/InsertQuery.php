<?php
namespace Query;

use App\Definition\QueryInterface;

class InsertQuery implements QueryInterface {
  protected $query;
  protected $table;
  protected $columns;
  protected $values;

  public function parseData($data): QueryInterface {
    $this->setTable($data->table);
    if (isset($data->columns)) {
      $this->setColumns($data->columns);
    }
    $this->setValues($data->values);
    return $this;
  }
  public function setTable(string $table) {
    $this->table = $table;
  }
  public function setColumns(array $columns) {
    $this->columns = $columns;
  }
  public function setValues(array $values) {
    $this->values = $values;
  }
  public function build(): QueryInterface {
    $query = ['INSERT INTO', $this->table];
    if (isset($this->columns)) {
      $query []= '(' . implode(', ', $this->columns) . ')';
    }
    $query []= 'VALUES';
    $data = [];
    foreach ($this->values as $values) {
      array_walk($values, function(&$val) {
        if (is_string($val)) {
          $val = "'" . $val . "'";
        }
      });
      $data []= '(' . implode(', ', $values) . ')';
    }
    $query []= implode(', ', $data);
    $this->query = implode(' ', $query);
    return $this;
  }
  public function execute(): array {
    $result = \ORM::getDb()->exec($this->query);
    return ['action' => 'insert', 'table' => $this->table, 'columns' => count($this->columns), 'result' => $result];
  }
}
