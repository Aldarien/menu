<?php
namespace App\Service;

use Psr\Container\ContainerInterface;
use App\Definition\Model;

class ModelFactory {
  protected $container;

  protected $model;
  protected $columns;
  protected $joins;
  protected $conditions;
  protected $orders;
  protected $limit;

  public function __construct(ContainerInterface $container) {
    $this->container = $container;
  }
  public function new(string $model_name) {
    return Model::factory($model_name)->create();
  }
  public function create(string $model_name, array $data) {
    $model = $this->find($model_name)->where($data)->one();
    if (!$model) {
      return Model::factory($model_name)->create($data);
    }
    return $model;
  }
  public function find(string $model_name) {
    $this->model = $model_name;
    $this->columns = [];
    $this->joins = [];
    $this->conditions = [];
    $this->orders = [];
    $this->limit = [];
    return $this;
  }
  public function reset(string $model_name) {
    $str = "\$table = $model_name::getTable();";
    eval($str);
    $query = "ALTER TABLE " . $table . " AUTO_INCREMENT = 0";
    \ORM::getDb()->exec($query);
  }
  /**
   * Set which columns are selected in query
   * @param  array  $data [field, ...]
   * @return [Factory]       [self]
   */
  public function select(array $data) {
    if ($this->columns == []) {
      $this->columns = $data;
      return $this;
    }
    $this->columns = array_merge($this->columns, $data);
    return $this;
  }
  /**
   * Joins in query
   * @param  array  $data [[join_table, join_table.column, ref_table.column[, 'operator' => operator][, 'alias' => alias][, 'type' => type]], ...]
   * @return [type]       [description]
   */
  public function join(array $data) {
    if ($this->joins == []) {
      $this->joins = $data;
      return $this;
    }
    $this->joins = array_merge($this->joins, $data);
    return $this;
  }
  /**
   * Add where conditions to query
   * @param  array  $data [[column => value | column => [value, operator]], ...]
   * @return [Factory]       [self]
   */
  public function where(array $data) {
    if ($this->conditions == []) {
      $this->conditions = $data;
      return $this;
    }
    $this->conditions = array_merge($this->conditions, $data);
    return $this;
  }
  /**
   * Add order by parameters to query
   * @param  array  $order [[column | column => order], ...]
   * @return [Factory]        [self]
   */
  public function sort(array $data) {
    if ($this->orders == [] or $this->orders == null) {
      $this->orders = $data;
      return $this;
    }
    $this->orders = array_merge($this->orders, $data);
    return $this;
  }
  /**
   * Add limit and/or offset to query
   * @param  array  $data ['limit' => limit[, 'offset' => offset]]
   * @return [type]       [description]
   */
  public function limit(array $data) {
    if (!isset($data['limit'])) {
      $data['limit'] = $data[0];
    }
    if (!isset($data['offset'])) {
      $data['offset'] = 0;
      if (isset($data[1])) {
        $data['offset'] = $data[1];
      }
    }
    $this->limit = (object) ['limit' => $data['limit'], 'offset' => $data['offset']];
    return $this;
  }
  /**
   * Find one
   * @return [Model] [The model that was found]
   */
  public function one($id = null) {
    if ($id != null) {
      $this->where(['id' => $id]);
    }
    $obj = $this->query()->findOne();
    if (!$obj) {
      return false;
    }
    $obj->setContainer($this->container);
    return $obj;
  }
  /**
   * Find many
   * @return [array] [An array with all Models found]
   */
  public function many() {
    $objs = $this->query()->findMany();
    array_walk($objs, function($obj) {
      $obj->setContainer($this->container);
    });
    return $objs;
  }
  public function array() {
    $objs = $this->many();
    $output = [];
    foreach ($objs as $obj) {
      $output []= $this->getArray($obj);
    }
    return $output;
  }

  protected function getArray($obj) {
    $parent = $obj->asArray();
    foreach (get_class_methods($obj) as $method) {
      if (ltrim($method, 'get') !== $method and ltrim($method, 'get') !== '') {
        $sub = strtolower(trim($method, 'get'));
        $parent[$sub] = [];
        $arr = $obj->{$method}();
        foreach ($arr as $o) {
          $parent[$sub] []= $this->getArray($o);
        }
      }
    }
    return $parent;
  }
  protected function query() {
    $query = Model::factory($this->model);
    $funcs = ['selects', 'joins', 'conditions', 'order', 'limit'];
    foreach ($funcs as $func) {
      $query = $this->{'parse'.ucfirst($func)}($query);
    }
    return $query;
  }
  protected function parseSelects($orm) {
    if ($this->columns == [] or $this->columns == null) {
      return $orm;
    }
    foreach ($this->columns as $column) {
      $orm = $orm->select($column);
    }
    return $orm;
  }
  protected function parseJoins($orm) {
    if ($this->joins == [] or $this->joins == null) {
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
  protected function parseConditions($orm) {
    if ($this->conditions == [] or $this->conditions == null) {
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
  protected function parseOrder($orm) {
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
  protected function parseLimit($orm) {
    if ($this->limit == null) {
      return $orm;
    }
    $orm = $orm->limit($this->limit->limit);
    if (isset($this->limit->offset)) {
      $orm = $orm->offset($this->limit->offset);
    }
    return $orm;
  }
}
