<?php

namespace model;

require_once("../src/model/CodeAnalysis.php");

class ClassName extends CodeAnalysis {
  /**
   * @var \PHPParser_Node_Stmt_Class
   */
  private $className;

  /**
   * @var array \PHPParser_Node_Stmt_Class
   */
  private $classes;

  /**
   * @var int
   */
  private $nrOfClasses;

  /**
   * @param \model\Code $code
   */
  public function __construct(Code $code) {
    parent::__construct($code);

    $this->classes = $this->code->filter('\PHPParser_Node_Stmt_Class');
    $this->nrOfClasses = count($this->classes);

    if ($this->nrOfClasses == 1) {
      $this->className = reset($this->classes);
    }
  }

  /**
   * Run all tests
   */
  public function runTests() {
    if ($this->nrOfClasses == 1) {
      if ($this->compareFilenameAndClassname()) {
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

    if ($this->nrOfStmtsOutsideClass() > $this->nrOfClasses) {
      $this->publish(new Error($this->code, CodeErrorType::NonOOPCode));
    }
  }

  /**
   * @return array
   */
  public function getCode() {
    if (isset($this->className))
      return $this->className->stmts;

    return $this->code->getParsedCode();
  }

  /**
   * @return string
   */
  public function __toString() {
    if (isset($this->className))
      return $this->className->name;

    return "Undefined";
  }

  /**
   * @return string
   */
  private function findFilename() {
    $file = array();
    preg_match('/(.*\/)*([a-zA-Z]*)(\..*)*\.php/',
               $this->code->getFileName(),
               $file);
    return $file[2];
  }

  /**
   * @return int
   */
  private function nrOfStmtsOutsideClass() {
    return count($this->code->getParsedCode()) -
           count($this->code->filter('\PHPParser_Node_Expr_Include'));
  }
  
  /**
   * @return boolean
   */
  private function compareFilenameAndClassname() {
    return strtolower($this->__toString()) != strtolower($this->findFilename());
  }
}
