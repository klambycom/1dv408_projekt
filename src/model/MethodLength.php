<?php

namespace model;

require_once("../src/model/CodeAnalysis.php");

class MethodLength extends CodeAnalysis {
  /**
   * Check length for each line
   */
  public function runTests() {
    $classes = $this->code->filter('\PHPParser_Node_Stmt_Class');

    foreach ($classes as $class) {
      $methods = $this->code->filter('\PHPParser_Node_Stmt_ClassMethod',
                                     $class->stmts);

      foreach ($methods as $method) {
        if ($this->getMethodLength($method) >= 30) {
            $this->publish(new Error($this->code,
                           CodeErrorType::MethodTooLong,
                           $method->getLine()));
        }
      }
    }
  }

  /**
   * @param \PHPParser_Node_Stmt_ClassMethod $method
   * @return int Nr of lines
   */
  private function getMethodLength(\PHPParser_Node_Stmt_ClassMethod $method) {
    return ($method->getAttribute('endLine') -
            $method->getAttribute('startLine'));
  }
}
