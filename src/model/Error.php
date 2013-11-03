<?php

namespace model;

require_once("../src/model/CodeErrorType.php");

class Error {
  /**
   * @var \model\Code
   */
  protected $code;

  /**
   * @var int
   */
  protected $errorType;

  /** 
   * @var int
   */
  protected $row;

  /**
   * @param \model\Code $code
   * @param int $errorType
   * @param int $row
   */
  public function __construct(Code $code, $errorType, $row = 0) {
    $this->code = $code;
    $this->errorType = $errorType;
    $this->row = $row;
  }

  /**
   * @return string
   */
  public function getFilename() {
    return $this->code->getFileName();
  }

  /**
   * @return int
   */
  public function getErrorType() {
    return $this->errorType;
  }

  /**
   * @return int
   */
  public function getRow() {
    return $this->row;
  }

  /**
   * @return string
   */
  public function getCode() {
    return $this->code->getRow($this->row);
  }
}
