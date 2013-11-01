<?php

namespace model;

class Settings {
  private $pdo_provider;
  private $pdo_host;
  private $pdo_database;
  private $pdo_username;
  private $pdo_password;

  public function __construct() {
    // @todo Read settings file

    /*
    $this->pdo_provider = "mysql";
    $this->pdo_host = "localhost";
    $this->pdo_database = "database";
    $this->pdo_username = "1dv408";
    $this->pdo_password = "mypassword";
     */

    $this->pdo_provider = "mysql";
    $this->pdo_host = "mysql462.loopia.se";
    $this->pdo_database = "klamby_com";
    $this->pdo_username = "1dv408@k90053";
    $this->pdo_password = "ws1fur2";
  }

  public function getPDO() {
    $connStr = "{$this->pdo_provider}:host={$this->pdo_host};dbname={$this->pdo_database}";
    return new \PDO($connStr, $this->pdo_username, $this->pdo_password);
  }

  public function githubId() {
    return '603ea2d8774629c7071e';
    //return '8cd562fe9a10f5c32152';
  }

  public function githubToken() {
    return '446498a44fd6d4a9c49326db45f67a13b7c19432';
    //return '565485de9321c5c7fdcefb7dea2326ad4f69fd95';
  }
}
