<?php
namespace App\Service\Config;

use App\Service\Config\Definition\Loader;

class JSONLoader implements Loader {
  protected $filename;

  public function __construct(string $filename) {
    $this->filename = $filename;
  }
  public function load() {
    $info = new \SplFileInfo($this->filename);
    return (object) [
      $info->getBasename($info->getExtension()) => json_decode(trim(file_get_contents($this->filename)))
    ];
  }
}
