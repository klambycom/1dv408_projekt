<?php

namespace controller;

require_once("../src/view/Application.php");
require_once("../src/controller/Login.php");
require_once("../src/controller/Result.php");
require_once("../src/model/Repository.php");
require_once("../src/model/Commit.php");
require_once("../src/view/Github.php");
require_once("../src/model/RepositoryDAL.php");

class Application {
  private $view;

  public function __construct() {
    $this->view = new \view\Application();
  }

  public function doRoute() {
    // @todo Check IP too
    if (isset($_POST['payload'])) {
      return $this->handlePayload();
    } else if (\preg_match('/(.*)\.png/', $this->view->getController(), $pic)) {
      return $this->getPicture($pic[1]);
    } else {
      return $this->route();
    }
  }

  private function route() {
    switch ($this->view->getController()) {
    case '':
      $controller = new Login();
      break;

    case 'resultat':
      $controller = new Result();
      break;

    default:
      return $this->view->notFound();
    }

    return $controller->doRoute();
  }

  private function handlePayload() {
    $github = new \view\Github();

    $repository = new \model\Repository($github->getId(),
                                        $github->getName(),
                                        $github->getOwner(),
                                        $github->isPrivate(),
                                        $github->getCreatedAt(),
                                        $github->getPushedAt(),
                                        $github->getMaster(),
                                        $github->getRefBranch());

    $rd = new \model\RepositoryDAL();
    $rd->createOrUpdate($repository);

    foreach ($github->getCommitsJson() as $commit) {
      $c = new \model\Commit($commit->{'id'},
                             $commit->{'timestamp'},
                             $commit->{'added'},
                             $commit->{'removed'},
                             $commit->{'modified'});
      $repository->addCommit($c);

      foreach ($c->getCode() as $code) {
        $facade = new \model\CodeAnalysisFacade($code);
        $facade->subscribe($repository);
        $facade->runTests();
      }
    }

    return "Tack!";
  }

  private function getPicture($repoName) {
    return $repoName;
  }
}
