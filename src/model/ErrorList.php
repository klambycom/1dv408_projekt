<?php

namespace model;

require_once("../src/model/Error.php");

class ErrorList {
  private $errors;

  public function __construct() {
    $this->errors = array();
  }

  public function add(Error $error) {
    $this->errors[] = $error;
  }

  public function getUniqueFilenames() {
    return array_unique(array_map($this->dot("getFilename"), $this->errors));
  }

  private function dot($function) {
    return function ($object) use ($function) { return $object->$function(); };
  }
}
