<?php

namespace controller;

require_once("../src/view/Login.php");
require_once("../src/model/User.php");
require_once("../src/model/AuthenticateUser.php");
require_once("../src/model/RepositoryDAL.php");
require_once("../src/model/Settings.php");

class Login {
  private $view;

  public function __construct() {
    $this->view = new \view\Login();
  }

  public function doRoute() {
    switch ($this->view->getPage()) {
      case '':
        return $this->doFirstPage();
      
      default:
        return $this->view->notFound();
    }
  }

  public function doFirstPage() {
    if ($this->view->authCodeIsSet()) {
      try {
        $user = new \model\AuthenticateUser($this->view->getAuthCode());
      } catch (\Exception $e) {
        // Let next try-catch take care of this
      }
    }

    try {
      $user = new \model\User();
    } catch (\model\NoTokenException $e) {
      $settings = new \model\Settings();
      return $this->view->login($settings->githubId());
    } catch (\model\InvalidTokenException $e) {
      $settings = new \model\Settings();
      return $this->view->login($settings->githubId());
    }

    try {
      $repositoryDAL = new \model\RepositoryDAL();
      $repositories = $repositoryDAL->findAllByOwner($user);
    } catch (\Exception $e) {
      $repositories = array();
    }

    return $this->view->userPage($user, $repositories);
  }
}
