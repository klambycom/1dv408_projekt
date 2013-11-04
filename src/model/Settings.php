<?php

namespace model;

class Settings {
  private $pdo_provider;
  private $pdo_host;
  private $pdo_database;
  private $pdo_username;
  private $pdo_password;

  public function __construct() {
    $this->pdo_provider = "mysql";
    $this->pdo_host = "localhost";
    $this->pdo_database = "database";
    $this->pdo_username = "1dv408";
    $this->pdo_password = "mypassword";
  }

  public function getPDO() {
    $connStr = "{$this->pdo_provider}:host={$this->pdo_host};
                dbname={$this->pdo_database}";
    return new \PDO($connStr, $this->pdo_username, $this->pdo_password);
  }

  public function githubId() {
    return '';
  }

  public function githubToken() {
    return '';
  }
}
