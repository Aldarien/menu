<?php
namespace App\Definition;

interface DBLoader
{
  public function __construct($config, $name);
  public function load();
}
