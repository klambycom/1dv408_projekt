<?php

namespace model;

require_once("../src/model/Error.php");

abstract class CodeAnalysis {
  private $listeners = array();
  private $nrOfErrors;
  protected $code;

  public function __construct(Code $code) {
    $this->code = $code;
    $this->nrOfErrors = 0;
  }

  public function nrOfErrors() {
    return $this->nrOfErrors;
  }

  public function subscribe(ResultObserver  $listener) {
    $this->listeners[] = $listener;
  }

  protected function publish(Error $error) {
    $this->nrOfErrors += 1;

    foreach ($this->listeners as $key => $listener) {
      $listener->error($error);
    }
  }

  abstract public function runTests();
}
