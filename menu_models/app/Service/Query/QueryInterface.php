<?php
namespace App\Service\Query;

interface QueryInterface {
  public function addColumn($data);
  public function setTable(string $name);
}
