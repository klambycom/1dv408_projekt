<?php

namespace controller;

//require_once("model/Code.php");
//require_once("model/CodeAnalysisFacade.php");
require_once("../src/view/Result.php");
require_once("../src/model/RepositoryDAL.php");
require_once("../src/model/ErrorDAL.php");

class Result {
  private $view;

  public function __construct() {
    $this->view = new \view\Result();
  }

  public function doRoute() {
    try {
      $repoDAL = new \model\RepositoryDAL();
      $repo = $repoDAL->findByName($this->view->getPage());

      $errorDAL = new \model\ErrorDAL($repo);

      return $this->view->showResultPage($repo, $errorDAL->all());
    } catch (\Exception $e) {
      return $this->view->notFound();
    }
  }
}

  //public function doResult() {
  //  $code  = new \model\Code("Foobar.php", $this->testcode);
  //  $tests = new \model\CodeAnalysisFacade($code);

  //  $this->result = new \view\Result();
  //  $tests->subscribe($this->result);

  //  $tests->runTests();

  //  return $this->result->showRapport($tests);
  //}
