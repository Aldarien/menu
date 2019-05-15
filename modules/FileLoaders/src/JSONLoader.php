<?php
namespace FileLoaders;

use App\Definition\FileLoader;

class JSONLoader implements FileLoader {
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
