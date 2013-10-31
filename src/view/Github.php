<?php

namespace view;

class Github {
  private $json;

  public function __construct() {
    if (isset($_POST['payload'])) {
      $this->json = json_decode($_POST['payload']);
    }
  }

  public function isUsedCorrect() {
    // @todo Check IP
    return isset($_POST['payload']);
  }

  public function getId() {
    return $this->json->{'repository'}->{'id'};
  }

  public function getName() {
    return $this->json->{'repository'}->{'name'};
  }

  public function getOwner() {
    return $this->json->{'repository'}->{'owner'}->{'name'};
  }

  public function isPrivate() {
    return $this->json->{'repository'}->{'private'};
  }

  public function getMaster() {
    return $this->json->{'repository'}->{'master_branch'};
  }

  public function getRefBranch() {
    return $this->json->{'ref'};
  }

  public function getCreatedAt() {
    return $this->json->{'repository'}->{'created_at'};
  }

  public function getPushedAt() {
    return $this->json->{'repository'}->{'pushed_at'};
  }

  public function getCommitsJson() {
    // @todo Think more about this one, if github change in commits i have to 
    //       change in controller and not here, BAD!
    return $this->json->{'commits'};
  }
}
