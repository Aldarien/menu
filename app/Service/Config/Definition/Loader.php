<?php
namespace App\Service\Config\Definition;

interface Loader {
  public function __construct(string $filename);
  public function load();
}
