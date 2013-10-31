<?php

namespace model;

require_once("model/Commit.php");
require_once("model/RepositoryDAL.php");
require_once("model/ResultObserver.php");
require_once("model/CodeAnalysisFacade.php");
require_once("model/ErrorDAL.php");

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

    // @todo Maybe should be in controller
    if ($master != "" && $ref != "") {
      $rd = new RepositoryDAL();
      $rd->createOrUpdate($this);
    }
  }

  /**
   * Implemented because of ResultObserver
   */
  public function error(Error $error) {
    $this->errorDAL->create($error);
  }

  public function addCommit(Commit $commit) {
    $commit->setRepositoryInformation("{$this->owner}/{$this->name}", $this->master);
    $this->commits[] = $commit;

    // @todo Move out from this to controller probebly, so i can use it in view 
    //       to, when that is needed.
    $facade = new CodeAnalysisFacade($commit->getCode());
    $facade->subscribe($this);
    $facade->runTests();
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

  public function __toString() {
    return "<b>{$this->owner}/{$this->name}</b> Id: {$this->id},
            Master: {$this->master}, Created at: {$this->created_at},
            Pushed at: {$this->pushed_at} " . implode("", $this->commits);
  }
}
