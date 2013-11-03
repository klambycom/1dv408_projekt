<?php

namespace view;

class Github {
  /**
   * @var json
   */
  private $json;

  public function __construct() {
    if (isset($_POST['payload'])) {
      $this->json = json_decode($_POST['payload']);
    }
  }

  /**
   * @return boolean
   */
  public function isUsedCorrect() {
    return isset($_POST['payload']);
  }

  /**
   * @return int
   */
  public function getId() {
    return $this->json->{'repository'}->{'id'};
  }

  /**
   * @return string
   */
  public function getName() {
    return $this->json->{'repository'}->{'name'};
  }

  /**
   * @return string
   */
  public function getOwner() {
    return $this->json->{'repository'}->{'owner'}->{'name'};
  }

  /**
   * @return boolean
   */
  public function isPrivate() {
    return $this->json->{'repository'}->{'private'};
  }

  /**
   * @return string
   */
  public function getMaster() {
    return $this->json->{'repository'}->{'master_branch'};
  }

  /**
   * @return string
   */
  public function getRefBranch() {
    return $this->json->{'ref'};
  }

  /**
   * @return int
   */
  public function getCreatedAt() {
    return $this->json->{'repository'}->{'created_at'};
  }

  /**
   * @return int
   */
  public function getPushedAt() {
    return $this->json->{'repository'}->{'pushed_at'};
  }

  /**
   * @return array
   */
  public function getCommitsJson() {
    return $this->json->{'commits'};
  }
}
