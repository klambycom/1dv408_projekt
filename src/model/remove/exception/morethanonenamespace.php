<?php

namespace model\exception;

class MoreThanOneNamespace extends \Exception {
  public function __construct() {
    parent::__construct();
  }
}
