<?php

namespace model;

require_once("model/CodeAnalysis.php");

// @todo Change name to FindClass
class ClassName extends CodeAnalysis {
  private $className;
  private $classes;
  private $nrOfClasses;

  public function __construct(Code $code) {
    parent::__construct($code);

    $this->classes = $this->code->filter('\PHPParser_Node_Stmt_Class');
    $this->nrOfClasses = count($this->classes);

    if ($this->nrOfClasses == 1) {
      $this->className = $classes[0];
    }
  }

  public function runTests() {
    if ($this->nrOfClasses == 1) {
      // @todo Lower case
      $file = explode(".php", $this->code->getFileName());
      if ($this->__toString() != $file[0]) {
        $this->addError($this->className->getLine(),
          "Class name (" . $this->__toString() . ") and file name ($file) don't match");
      }
    } else if ($this->nrOfClasses > 1) {
      foreach ($this->classes as $key => $val) {
        $this->addError($val->getLine());
      }
    }

    if (count($this->code->getParsedCode()) > $this->nrOfClasses) {
      // @todo
      $this->addError(0, "Code outside class");
    }

    if ($this->nrOfErrors() > 0)
      $this->publish();
  }

  public function getCode() {
    if (isset($this->className))
      return $this->className->stmts;

    return $this->code->getParsedCode();
  }

  public function __toString() {
    if (isset($this->className))
      return $this->className->name;

    return "Undefined";
  }
}
