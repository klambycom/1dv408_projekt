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
  /**
   * @var \view\Application
   */
  private $view;

  /**
   * @var \view\Github
   */
  private $github;

  /**
   * Create Application and Github view
   */
  public function __construct() {
    $this->view = new \view\Application();
    $this->github = new \view\Github();
  }

  /**
   * @return HTML depending on controller and page
   */
  public function doRoute() {
    if ($this->github->isUsedCorrect()) {
      return $this->handlePayload();
    } else if (\preg_match('/(.*)\.png/', $this->view->getController(), $pic)) {
      return $this->getPicture($pic[1]);
    } else {
      return $this->route();
    }
  }

  /**
   * @return HTML depending on controller
   */
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

  /**
   * Handle data from Github
   * @return String Don't know why, but feels good when I test the code.
   */
  private function handlePayload() {
    $repository = $this->createRepository();
    $errorDAL = new \model\ErrorDAL($repository);

    foreach ($this->github->getCommitsJson() as $commit) {
      $c = new \model\Commit($commit->{'id'},
                             $commit->{'timestamp'},
                             $commit->{'added'},
                             $commit->{'removed'},
                             $commit->{'modified'});
      $repository->addCommit($c);

      $errorDAL->removeAll($c->getFiles());

      foreach ($c->getCode() as $code) {
        try {
          $facade = new \model\CodeAnalysisFacade($code);
          $facade->subscribe($repository);
          $facade->runTests();
        } catch (\Exception $e) {
          // do nothing
        }
      }
    }

    return "Tack!";
  }

  /**
   * @return \model\Repository Created from data from Github
   */
  private function createRepository() {
    $repository = new \model\Repository($this->github->getId(),
                                        $this->github->getName(),
                                        $this->github->getOwner(),
                                        $this->github->isPrivate(),
                                        $this->github->getCreatedAt(),
                                        $this->github->getPushedAt(),
                                        $this->github->getMaster(),
                                        $this->github->getRefBranch());

    $rd = new \model\RepositoryDAL();
    $rd->createOrUpdate($repository);

    return $repository;
  }

  /**
   * Show a image depending on nr of errors in repository
   * @param string $repoName
   */
  private function getPicture($repoName) {
    $rd = new \model\RepositoryDAL();
    $nrOfErrors = $rd->nrOfErrors($repoName);

    if ($nrOfErrors > 0) {
      $file = 'images/Sad.png';
    } else {
      $file = 'images/Happy.png';
    }

    $size = getimagesize($file);
    header('Content-type: '.$size['mime']);
    readfile($file);
  }
}
