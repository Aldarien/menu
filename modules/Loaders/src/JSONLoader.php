<?php
namespace Loader;

use App\Definition\Loader;

class JSONLoader implements Loader {
  protected $name;
  protected $filename;

  public function __construct(string $filename) {
    $this->filename = $filename;
    $info = new \SplFileInfo($this->filename);
    $this->name = $info->getBasename($info->getExtension());
  }
  public function load() {
    return json_decode(trim(file_get_contents($this->filename)));
  }
}
