<?php

namespace model;

require_once("../src/model/Commit.php");
require_once("../src/model/ResultObserver.php");
require_once("../src/model/CodeAnalysisFacade.php");
require_once("../src/model/ErrorDAL.php");

class Repository implements ResultObserver {
  /**
   * @var int
   */
  private $id;

  /**
   * @var string
   */
  private $name;

  /**
   * @var string
   */
  private $owner;

  /**
   * @var boolean
   */
  private $private;

  /**
   * @var string
   */
  private $master;

  /**
   * @var int
   */
  private $created_at;

  /**
   * @var int
   */
  private $pushed_at;

  /**
   * @var \model\Commit
   */
  private $commits;

  /**
   * @var \model\ErrorDAL
   */
  private $errorDAL;

  /**
   * @param int $id
   * @param string $name
   * @param string $owner
   * @param boolean $private
   * @param int $created_at
   * @param int $pushed_at
   * @param string $master
   * @param string $ref
   * @throws Exception if not pushed to master branch
   */
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
   * @param \model\Error $error
   */
  public function error(Error $error) {
    $this->errorDAL->create($error);
  }

  /**
   * @param \model\Commit $commit
   */
  public function addCommit(Commit $commit) {
    $commit->setRepositoryInformation("{$this->owner}/{$this->name}",
                                      $this->master);
    $this->errorDAL->deleteFiles($commit->getFiles());
    $this->commits[] = $commit;
  }

  /**
   * @return int
   */
  public function getId() {
    return $this->id;
  }

  /**
   * @return string
   */
  public function getName() {
    return $this->name;
  }

  /**
   * @return string
   */
  public function getOwner() {
    return $this->owner;
  }

  /**
   * @return boolean
   */
  public function isPrivate() {
    return $this->private;
  }

  /**
   * @return int
   */
  public function getCreatedAt() {
    return $this->created_at;
  }

  /**
   * @return int
   */
  public function getPushedAt() {
    return $this->pushed_at;
  }
}
