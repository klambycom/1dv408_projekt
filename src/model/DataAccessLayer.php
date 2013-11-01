<?php

namespace model;

require_once("../src/model/Settings.php");

abstract class DataAccessLayer {
  protected $pdo;

  public function __construct() {
    $settings = new Settings();
    $this->pdo = $settings->getPDO();
  }

  abstract public function setup();
}
