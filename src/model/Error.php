<?php

namespace model;

final class CodeErrorType {
  /*
    CodeErrorType::MoreThanOneClass
    CodeErrorType::WrongFilenameOrClassname
    CodeErrorType::MissingNamespace
    CodeErrorType::MoreThanOneNamespace
    CodeErrorType::NonOOPCode
   */

  const MoreThanOneClass = 0;
  const NonOOPCode = 1;
  const WrongFilenameOrClassname = 2;
  const MissingNamespace = 3;
  const MoreThanOneNamespace = 4;

  private function __construct() {}
}

class Error {
  protected $code;
  protected $errorType;
  protected $row;

  public function __construct(Code $code, $errorType, $row = 0) {
    $this->code = $code;
    $this->errorType = $errorType;
    $this->row = $row;
  }

  public function getFilename() {
    return $this->code->getFileName();
  }

  public function getErrorType() {
    return $this->errorType;
  }

  public function getRow() {
    return $this->row;
  }

  public function getCode() {
    return $this->code->getRow($this->row);
  }
}
