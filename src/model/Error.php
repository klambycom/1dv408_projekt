<?php

namespace model;

final class CodeErrorType {
  /**
   * @const int
   */
  const MoreThanOneClass = 0;

  /**
   * @const int
   */
  const NonOOPCode = 1;

  /**
   * @const int
   */
  const WrongFilenameOrClassname = 2;

  /**
   * @const int
   */
  const MissingNamespace = 3;

  /**
   * @const int
   */
  const MoreThanOneNamespace = 4;

  /**
   * @const int
   */
  const MethodTooLong = 5;

  /**
   * @const int
   */
  const LineTooLong = 6;

  private function __construct() {}
}

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
