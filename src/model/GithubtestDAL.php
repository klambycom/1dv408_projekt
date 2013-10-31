<?php

namespace model;

class GithubtestDAL {
  private $pdo;

  public function __construct() {
    //$this->pdo = new \PDO("mysql:host=localhost;dbname=database", "1dv408", "mypassword");
    $this->pdo = new \PDO("mysql:host=mysql462.loopia.se;dbname=klamby_com", "1dv408@k90053", "ws1fur2");
  }

  public function add($code) {
    $query = $this->pdo->prepare("INSERT INTO `githubtest` (`payload`) VALUES (:code)");
    $query->execute(array("code" => $code));
  }

  public function find($id) {
    $query = $this->pdo->prepare("SELECT * FROM `githubtest` WHERE id = :id LIMIT 1");
    $query->execute(array(":id" => $id));
    $result = $query->fetch(\PDO::FETCH_ASSOC);

    if ($query->rowCount() < 1)
      throw new \Exception("no matching payload");

    return $result["payload"];
  }
}
