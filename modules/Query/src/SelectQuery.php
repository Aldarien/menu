<?php
namespace Query;

use App\Definition\QueryInterface;

class SelectQuery implements QueryInterface {
  protected $query;
  protected $fields;
  protected $table;
  protected $joins;
  protected $conditions;
  protected $orders;
  protected $grouping;
  protected $limits;

  public function parseData($data): QueryInterface {
    /**
     * $data
     * fields:
     *    - name: <name>
     *      [alias: <alias>]
     *    ...
     * tables:
     *  from: <table>
     *  join:
     *    - table: <table>
     *      condition:
     *        field1: <table1.field>
     *        field2: <table2.field>
     *        [operatior: <operator>]
     *      [alias: <alias>]
     *  where:
     *    - field1: <table1.field | expresion>
     *      field2: <table2.field>
     *      [operator: <operator>]
     *    ...
     *  order:
     *    - field: <table.field | expresion>
     *      [direction: <asc | desc>]
     *    ...
     *  group:
     *    - <table.field>
     *  limit: <limit>
     *  offset: <offset>
     */
    if (isset($data->fields)) {
      $this->select((array) $data->fields);
    }
    $this->from($data->tables->from);
    if (isset($data->tables->join)) {
      $output = [];
      foreach ($data->tables->join as $join) {
        $j = [];
      }
      $this->joins($data->tables->join);
    }
    return $this;
  }
  public function build(): QueryInterface {
    $orm = \ORM::forTable($this->table);
    $orm = $this->parseFields($orm);
    $orm = $this->parseJoins($orm);
    $orm = $this->parseConditions($orm);
    $orm = $this->parseOrder($orm);
    $orm = $this->parseGroup($orm);
    $orm = $this->parseLimit($orm);
    $this->query = $orm;
    return $this;
  }
  public function execute(): array {
    $result = $this->query->findMany();
    return ['action' => 'select', 'table' => $this->table, 'fields' => count($this->fields), 'result' => $result];
  }

  protected function parseFields(\ORM $orm): \ORM {
    if ($this->fields == null) {
      return $orm;
    }
    foreach ($this->fields as $field) {
      $orm = $orm->select($field);
    }
    return $orm;
  }
  protected function parseJoins(\ORM $orm): \ORM {
    if ($this->joins == null) {
      return $orm;
    }
    foreach ($this->joins as $join) {
      $info = [];
      $info []= "'" . $join[0] . "'";
      $info2 = [];
      $info2 []= $join[1];
      if (isset($join['operator'])) {
        $info2 []= $join['operator'];
      } else {
        $info2 []= '=';
      }
      $info2 []= $join[2];
      $info []= "['" . implode("', '", $info2) . "']";
      if (isset($join['alias'])) {
        $info []= $join['alias'];
      }
      if (!isset($join['type'])) {
        $join['type'] = 'join';
      }
      switch (strtolower($join['type'])) {
        case 'join':
        case 'right':
          $func = 'join';
          break;
        case 'left':
          $func = 'leftJoin';
          break;
        case 'raw':
          $func = 'rawJoin';
          break;
      }
      $str = "\$orm = \$orm->{$func}(" . implode(", ", $info) . ");";
      eval($str);
    }
    return $orm;
  }
  protected function parseConditions(\ORM $orm): \ORM {
    if ($this->conditions == null) {
      return $orm;
    }
    foreach ($this->conditions as $column => $value) {
      if (is_array($value)) {
        list($value, $op) = $value;
        switch ($op) {
          case '>':
          case 'gt':
            $orm = $orm->whereGt($column, $value);
          break;
        }
      } else {
        $orm = $orm->where($column, $value);
      }
    }
    return $orm;
  }
  protected function parseOrder(\ORM $orm): \ORM {
    if ($this->orders == null) {
      return $orm;
    }
    foreach ($this->orders as $column => $order) {
      if (is_numeric($column)) {
        $column = $order;
        $order = 'asc';
      }
      switch (strtolower($order)) {
        case 'asc':
        default:
          $orm = $orm->orderByAsc($column);
          break;
        case 'desc':
          $orm = $orm->orderByDesc($column);
          break;
        case 'expr':
          $orm = $orm->orderByExpr($column);
          break;
      }
    }
    return $orm;
  }
  protected function parseGroup(\ORM $orm): \ORM {
    if ($this->grouping == null) {
      return $orm;
    }
    foreach ($this->grouping as $group) {
      $f = 'groupBy';
      if (strpos($group, '(') !== false) {
        $f = 'groupByExpr';
      }
      $orm = $orm->{$f}($group);
    }
    return $orm;
  }
  protected function parseLimit(\ORM $orm): \ORM {
    if ($this->limits == null) {
      return $orm;
    }
    $orm = $orm->limit($this->limit->limit);
    if (isset($this->limit->offset)) {
      $orm = $orm->offset($this->limit->offset);
    }
    return $orm;
  }
  protected function store($property, $data): QueryInterface {
    if ($this->$property == null) {
      $this->$property = $data;
      return $this;
    }
    $this->$property = array_merge($this->$property, $data);
    return $this;
  }
  public function select($fields): QueryInterface {
    if (!is_array($fields)) {
      $fields = [$fields];
    }
    return $this->store('fields', $fields);
  }
  public function from(string $table): QueryInterface {
    $this->table = $table;
    return $this;
  }
  public function join(array $data): QueryInterface {
    return $this->store('joins', $data);
  }
  public function where(array $conditions): QueryInterface {
    return $this->store('conditions', $conditions);
  }
  public function sort($order): QueryInterface {
    if (!is_array($order)) {
      $order = [$order];
    }
    return $this->store('orders', $order);
  }
  public function groupBy($data): QueryInterface {
    if (!is_array($data)) {
      $data = [$data];
    }
    return $this->store('grouping', $data);
  }
  public function limit(int $n): QueryInterface {
    if ($this->limits == null) {
      $this->limits = (object) ['limit' => 0, 'offset' => 0];
    }
    $this->limits->limit = $n;
    return $this;
  }
  public function offset(int $n): QueryInterface {
    if ($this->limits == null) {
      $this->limits = (object) ['limit' => 0, 'offset' => 0];
    }
    $this->limits->offset = $n;
    return $this;
  }
}
