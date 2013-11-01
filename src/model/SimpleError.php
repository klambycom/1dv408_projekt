<?php

namespace model;

require_once("../src/model/Error.php");

class SimpleError extends Error {
  private $filename;

  public function __construct($filename, $errorType, $row, $code) {
    $this->filename = $filename;
    $this->errorType = $errorType;
    $this->row = $row;
    $this->code = $code;
  }

  public function getFilename() {
    return $this->filename;
  }

  public function getCode() {
    return $this->code;
  }
}
