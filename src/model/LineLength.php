<?php

namespace model;

require_once("../src/model/CodeAnalysis.php");

class LineLength extends CodeAnalysis {
  public function runTests() {
    $rows = $this->code->getRawCode();
    for ($i = 0; $i < count($rows); $i++) {
      if (strlen($rows[$i]) >= 80) {
        $this->publish(new Error($this->code,
                                 CodeErrorType::LineTooLong,
                                 $i + 1));
      }
    }
  }
}
