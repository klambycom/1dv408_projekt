<?php

namespace model;

require_once("../src/model/Error.php");

abstract class CodeAnalysis {
  /**
   * @var array
   */
  private $listeners = array();

  /**
   * @var int
   */
  private $nrOfErrors;

  /**
   * @var \model\Code
   */
  protected $code;

  /**
   * @param \model\Code $code
   */
  public function __construct(Code $code) {
    $this->code = $code;
    $this->nrOfErrors = 0;
  }

  /**
   * @return int
   */
  public function nrOfErrors() {
    return $this->nrOfErrors;
  }

  /**
   * @param \model\ResultObserver $listener
   */
  public function subscribe(ResultObserver  $listener) {
    $this->listeners[] = $listener;
  }

  /**
   * @param \model\Error $error
   */
  protected function publish(Error $error) {
    $this->nrOfErrors += 1;

    foreach ($this->listeners as $key => $listener) {
      $listener->error($error);
    }
  }

  abstract public function runTests();
}
