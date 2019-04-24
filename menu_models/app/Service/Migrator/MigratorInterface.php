<?php
namespace App\Service\Migrator;

interface MigratorInterface {
  public function load(string $filename): MigratorInterface;
  public function migrate();
}
