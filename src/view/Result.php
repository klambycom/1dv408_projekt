<?php

namespace view;

require_once("model/ResultObserver.php");
require_once("model/CodeAnalysis.php");

class Result implements \model\ResultObserver {
  public function showErrors(\model\CodeAnalysis $result) {
    var_dump($result->getErrors());
  }
}
