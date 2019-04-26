<?php
namespace App\Definition;

interface QueryInterface {
  public function parseData($data): QueryInterface;
  public function build(): QueryInterface;
  public function execute(): array;
}
