<?php

namespace model;

require_once("../src/model/CodeAnalysis.php");

class FindNamespace extends CodeAnalysis {
  /**
   * @var array
   */
  private $namespaces;

  /**
   * @var \PHPParser_Node_Stmt_Namespace
   */
  private $namespace;

  /**
   * @param \model\Code $code
   */
  public function __construct(Code $code) {
    parent::__construct($code);

    $this->namespaces = $this->code->filter('\PHPParser_Node_Stmt_Namespace');

    if (count($this->namespaces) == 1) {
      $this->namespace = $this->namespaces[0];
    }
  }

  /**
   * Run all tests
   */
  public function runTests() {
    $nrOfNamespaces = count($this->namespaces);

    if ($nrOfNamespaces < 1) {
      $this->publish(new Error($this->code, CodeErrorType::MissingNamespace));
    } else if ($nrOfNamespaces > 1) {
      foreach ($this->namespaces as $key => $val) {
        $this->publish(new Error($this->code, CodeErrorType::MoreThanOneNamespace, $val->getLine()));
      }
    }
  }

  /**
   * @return string
   */
  public function __toString() {
    if (isset($this->namespace))
      return $this->namespace->name->__toString();

    return "No namespace";
  }

  /**
   * @return array
   */
  public function getCode() {
    if (isset($this->namespace))
      return $this->namespace->stmts;

    return $this->code->getParsedCode();
  }
}
