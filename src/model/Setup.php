<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once("../src/model/Repository.php");
require_once("../src/model/RepositoryDAL.php");
require_once("../src/model/ErrorDAL.php");

class FakeRepository extends \model\Repository {
  public function __construct() {
  }
}

class Setup {
  public function __construct() {
    $r = new \model\RepositoryDAL();
    $r->setup();

    $e = new \model\ErrorDAL(new FakeRepository());
    $e->setup();
  }
}

new Setup();
