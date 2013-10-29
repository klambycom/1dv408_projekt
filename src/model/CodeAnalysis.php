<?php

namespace model;

require_once("model/Error.php");

abstract class CodeAnalysis {
  private $listeners = array();
  private $errors = array();
  protected $code;

  public function __construct(Code $code) {
    $this->code = $code;
  }

  public function nrOfErrors() {
    return count($this->errors);
  }

  public function getErrors() {
    return $this->errors;
  }

  public function subscribe(ResultObserver  $listener) {
    $this->listeners[] = $listener;
  }

  protected function publish() {
    foreach ($this->listeners as $key => $listener) {
      $listener->showErrors($this);
    }
  }

  protected function addError($row, $badCode = "") {
    if (empty($badCode)) {
      $badCode = $this->code->getRow($row);
    }

    $this->errors[] = new Error("classname", $this->code->getFileName(), $row, $badCode);
  }

  abstract public function runTests();
}
