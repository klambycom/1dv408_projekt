<?php

namespace model;

require_once("../src/model/Commit.php");
require_once("../src/model/ResultObserver.php");
require_once("../src/model/CodeAnalysisFacade.php");
require_once("../src/model/ErrorDAL.php");

class Repository implements ResultObserver {
  private $id;
  private $name;
  private $owner;
  private $private;
  private $master;
  private $created_at;
  private $pushed_at;
  private $commits;
  private $errorDAL;

  public function __construct($id, $name, $owner, $private, $created_at, $pushed_at, $master = "", $ref = "") {
    if ("refs/heads/$master" != $ref && $master != "")
      throw new \Exception("Didn't push to $master");

    $this->id = $id;
    $this->name = $name;
    $this->owner = $owner;
    $this->private = $private;
    $this->master = $master;
    $this->created_at = $created_at;
    $this->pushed_at = $pushed_at;

    $this->errorDAL = new ErrorDAL($this);
  }

  /**
   * Implemented because of ResultObserver
   */
  public function error(Error $error) {
    $this->errorDAL->create($error);
  }

  public function addCommit(Commit $commit) {
    $commit->setRepositoryInformation("{$this->owner}/{$this->name}", $this->master);
    $this->errorDAL->deleteFiles($commit->getRemovedFiles());
    $this->commits[] = $commit;
  }

  public function tmpGetCode() {
    foreach ($this->commits as $c) {
      var_dump($c->getCode());
    }
  }

  public function getId() {
    return $this->id;
  }

  public function getName() {
    return $this->name;
  }

  public function getOwner() {
    return $this->owner;
  }

  public function isPrivate() {
    return $this->private;
  }

  public function getCreatedAt() {
    return $this->created_at;
  }

  public function getPushedAt() {
    return $this->pushed_at;
  }
}
