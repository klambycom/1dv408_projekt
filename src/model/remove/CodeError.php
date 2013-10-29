<?php

namespace model;

class CodeError {
  private $filename;
  private $row;
  private $errorType;
  private $invalidCode;

  public function __construct($filename, $row, $invalidCode, $errorType) {
    $this->filename = $filename;
    $this->row = $row;
    $this->errorType = $errorType;
    $this->invalidCode = $invalidCode;
  }

  public function getFilename() {
    return $this->filename;
  }

  public function getRow() {
    return $this->row;
  }

  public function getErrorType() {
    return $this->errorType();
  }
}
