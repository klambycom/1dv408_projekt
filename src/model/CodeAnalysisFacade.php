<?php

namespace model;

require_once("../src/model/CodeAnalysis.php");
require_once("../src/model/FindNamespace.php");
require_once("../src/model/ClassName.php");
require_once("../src/model/MethodLength.php");
require_once("../src/model/LineLength.php");

class CodeAnalysisFacade extends CodeAnalysis {
  /**
   * @var array
   */
  private $analysises = array();

  /**
   * @var string
   */
  private $namespace;

  /**
   * @var string
   */
  private $class;

  /**
   * @param \model\Code $code
   * @throw \Exception if index.php or default.php
   */
  public function __construct(Code $code) {
    if (\preg_match('/(.*\/)*(index|default){1}\.php/', $code->getFileName()))
      throw new \Exception();

    parent::__construct($code);

    $this->analysises[0] = new FindNamespace($code);
    $this->code->updateCode($this->analysises[0]->getCode());

    $this->analysises[1] = new ClassName($code);
    $this->analysises[2] = new MethodLength($code);
    $this->analysises[3] = new LineLength($code);
  }

  /**
   * Run all tests
   */
  public function runTests() {
    foreach ($this->analysises as $key => $val) {
      $val->runTests();
    }
  }

  /**
   * @return String
   */
  public function getNamespace() {
    return $this->analysises[0]->__toString();
  }

  /**
   * @return String
   */
  public function getClassName() {
    return $this->analysises[1]->__toString();
  }

  /**
   * @param \model\ResultObserver $listener
   */
  public function subscribe(ResultObserver $listener) {
    foreach ($this->analysises as $key => $analysis) {
      $analysis->subscribe($listener);
    }
  }

  /**
   * @return int
   */
  public function nrOfErrors() {
    $count = 0;

    foreach ($this->analysis as $key => $analysis) {
      $count += $analysis->nrOfErrors();
    }

    return $count;
  }
}
