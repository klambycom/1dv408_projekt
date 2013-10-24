<?php

namespace controller;

require_once("view/application.php");

class Application {
  private $view;

  public function __construct() {
    $this->view = new \view\Application();

    //if ($this->view->getPage() == "login") {
    //  $this->controller = new \controller\Login();
    //}
  }

  public function doApplication() {
    $header = $this->view->showHeader();
    $footer = $this->view->showFooter();

    if ($this->view->isFirstPage()) {
      $content = $this->doFirstPage();
    } else {
      $content = "404";
    }

    return "$header
            $content
            $footer";
  }

  public function doFirstPage() {
    return "<h1>Hello, World!</h1>";
  }
}
