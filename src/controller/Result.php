<?php

namespace controller;

require_once("../src/view/Result.php");
require_once("../src/model/RepositoryDAL.php");
require_once("../src/model/ErrorDAL.php");

class Result {
  /**
   * @var \view\Result
   */
  private $view;

  public function __construct() {
    $this->view = new \view\Result();
  }

  /**
   * @return string
   */
  public function doRoute() {
    try {
      $repoDAL = new \model\RepositoryDAL();
      $repo = $repoDAL->findById($this->view->getPage());

      $errorDAL = new \model\ErrorDAL($repo);

      return $this->view->showResultPage($repo, $errorDAL->all());
    } catch (\Exception $e) {
      return $this->view->notFound();
    }
  }
}
