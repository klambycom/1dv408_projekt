<?php

namespace model;

require_once("../src/model/CodeAnalysis.php");

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
      $this->className = reset($this->classes);
    }
  }

  public function runTests() {
    if ($this->nrOfClasses == 1) {
      $file = array();
      preg_match('/(.*\/)*([a-zA-Z]*)(\..*)*\.php/',
                 $this->code->getFileName(),
                 $file);
      if (strtolower($this->__toString()) != strtolower($file[2])) {
        $this->publish(new Error($this->code,
                                 CodeErrorType::WrongFilenameOrClassname,
                                 $this->className->getLine()));
      }
    } else if ($this->nrOfClasses > 1) {
      foreach ($this->classes as $key => $val) {
        $this->publish(new Error($this->code,
                                 CodeErrorType::MoreThanOneClass,
                                 $val->getLine()));
      }
    }

    $nrOfStmtsOutsideClass = count($this->code->getParsedCode()) -
            count($this->code->filter('\PHPParser_Node_Expr_Include'));

    if ($nrOfStmtsOutsideClass > $this->nrOfClasses) {
      $this->publish(new Error($this->code, CodeErrorType::NonOOPCode));
    }
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
