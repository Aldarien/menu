<?php
namespace App\Service;

class Query {
  protected $action;
  protected $query;

  public function __construct($action) {
    $this->action = implode("\\", ['Query', ucfirst(strtolower($action)) . 'Query']);;
  }
  public function parseData(object $data): Query {
    $class = $this->action;
    if (!class_exists($class)) {
      throw new Exception($class . ' not found in Query.');
    }
    $this->query = new $class;
    $this->query->parseData($data);
    return $this;
  }
  public function build(): Query {
    $this->query->build();
    return $this;
  }
  public function execute(): array {
    return $this->query->execute();
  }
  public function run(object $data): array {
    $class = $this->action;
    $this->query = new $class;
    return $this->query->parseData($data)->build()->execute();
  }
}
