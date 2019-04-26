<?php
namespace Loader;

use App\Definition\Loader;

class PHPLoader implements Loader {
  protected $name;
  protected $filename;

  public function __construct(string $filename) {
    $this->filename = $filename;
    $info = new \SplFileInfo($this->filename);
    $this->name = $info->getBasename($info->getExtension());
  }
  public function load() {

    return include_once($this->filename);
  }
}
