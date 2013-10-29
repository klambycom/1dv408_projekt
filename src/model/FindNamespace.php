<?php

namespace model;

require_once("model/CodeAnalysis.php");

class FindNamespace extends CodeAnalysis {
  private $namespaces;
  private $namespace;

  public function __construct(Code $code) {
    parent::__construct($code);

    $this->namespaces = $this->code->filter('\PHPParser_Node_Stmt_Namespace');

    if (count($this->namespaces) == 1) {
      $this->namespace = $this->namespaces[0];
    }
  }

  public function runTests() {
    // @todo runTests and addErrors should merge
    if (count($this->namespaces) != 1) {
      $this->addErrors($this->namespaces);
    }

    if ($this->nrOfErrors() > 0)
      $this->publish();
  }

  public function __toString() {
    if (isset($this->namespace))
      return $this->namespace->name->__toString();

    return "No namespace";
  }

  public function getCode() {
    if (isset($this->namespace))
      return $this->namespace->stmts;

    return $this->code->getParsedCode();
  }

  private function addErrors($namespaces) {
    $nrOfNamespaces = count($namespaces);

    if ($nrOfNamespaces < 1) {
      $this->addError(0, "Missing namespace");
    } else if ($nrOfNamespaces > 1) {
      foreach ($namespaces as $key => $val) {
        $this->addError($val->getLine());
      }
    }
  }
}
