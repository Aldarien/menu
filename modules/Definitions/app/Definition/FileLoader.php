<?php
namespace App\Definition;

interface FileLoader {
  public function __construct(string $filename);
  public function load();
}
