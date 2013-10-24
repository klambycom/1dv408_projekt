<?php

namespace view;

require_once("view/application.php");

class Application {
  private $routes = array();

  public function __construct() {
    $this->routes["/"] = array('controller' => 'Application',
                               'action' => 'doFrontPage');
  }

  public function isFirstPage() {
    return empty($_GET['page']);
  }

  public function showHeader($title = "") {
    return "<!doctype html>
            <html lang='sv'>
            <head>
              <meta charset='utf-8'>
              <title>$title - ?</title>
            </head>
            <body>";
  }

  public function showFooter() {
    return "</body>
            </html>";
  }
}
