<?php

namespace model;

require_once("../src/model/CodeAnalysis.php");

class MethodLength extends CodeAnalysis {
  public function runTests() {
    $classes = $this->code->filter('\PHPParser_Node_Stmt_Class');

    foreach ($classes as $class) {
      $methods = $this->code->filter('\PHPParser_Node_Stmt_ClassMethod', $class->stmts);

      foreach ($methods as $method) {
        var_dump($method);
        if (($method->getAttribute('endLine') -
          $method->getAttribute('startLine')) >= 30) {
            var_dump($this->code);
            var_dump($method->getLine());
            $this->publish(new Error($this->code,
              CodeErrorType::MethodTooLong,
              $method->getLine()));
        }
      }
    }
  }
}