<?php

namespace model;

require_once("../src/model/CodeAnalysis.php");
require_once("../src/model/FindNamespace.php");
require_once("../src/model/ClassName.php");

class CodeAnalysisFacade extends CodeAnalysis {
  private $analysises = array();
  private $namespace;
  private $class;

  public function __construct(Code $code) {
    parent::__construct($code);

    $this->analysises[0] = new FindNamespace($code);
    $this->code->updateCode($this->analysises[0]->getCode());

    $this->analysises[1] = new ClassName($code);
    $this->code->updateCode($this->analysises[1]->getCode());
  }

  public function runTests() {
    foreach ($this->analysises as $key => $val) {
      $val->runTests();
    }
  }

  public function getNamespace() {
    return $this->analysises[0]->__toString();
  }

  public function getClassName() {
    return $this->analysises[1]->__toString();
  }

  public function subscribe(ResultObserver $listener) {
    foreach ($this->analysises as $key => $analysis) {
      $analysis->subscribe($listener);
    }
  }

  public function nrOfErrors() {
    $count = 0;

    foreach ($this->analysis as $key => $analysis) {
      $count += $analysis->nrOfErrors();
    }

    return $count;
  }

  public function debugGetErrors() {
    $errors = array();

    foreach ($this->analysises as $key => $analysis) {
      $errors[] = $analysis->getErrors();
    }

    return $errors;
  }
}
