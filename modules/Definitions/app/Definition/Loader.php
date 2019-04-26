<?php
namespace App\Definition;

interface Loader {
  public function __construct(string $filename);
  public function load();
}
