<?php

namespace model;

require_once("../src/model/Error.php");

class SimpleError extends Error {
  /**
   * @var string
   */
  private $filename;

  /**
   * @param string $filename
   * @param int $errorType
   * @param int $row
   * @param string $code
   */
  public function __construct($filename, $errorType, $row, $code) {
    $this->filename = $filename;
    $this->errorType = $errorType;
    $this->row = $row;
    $this->code = $code;
  }

  /**
   * @return string
   */
  public function getFilename() {
    return $this->filename;
  }

  /**
   * @return string
   */
  public function getCode() {
    return $this->code;
  }
}
