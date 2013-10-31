<?php

namespace controller;

require_once("view/application.php");
require_once("model/Code.php");
require_once("model/CodeAnalysisFacade.php");
require_once("view/Result.php");

class Application {
  private $view;
  private $result;

  private $testcode;

  public function __construct() {
    $this->view = new \view\Application();
    $this->result = new \view\Result();

    $this->testcode = <<<'CODE'
<?php

//namespace model;

class Foobar {
  function printLine($msg) {
    $hej = new Foobar();
    echo $msg, "\n";
  }
}

class Test {
  function foo() {
  }
}

printLine('Hello World!!!');
CODE;

  }

  public function doApplication() {
    $header = $this->view->showHeader();
    $footer = $this->view->showFooter();

    if ($this->view->isFirstPage()) {
      //$content = $this->doFirstPage();
      $content = $this->doResult();
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

  public function doResult() {
    $code  = new \model\Code("Foobar.php", $this->testcode);
    $tests = new \model\CodeAnalysisFacade($code);

    $this->result = new \view\Result();
    $tests->subscribe($this->result);

    $tests->runTests();

    return $this->result->showRapport($tests);
  }
}
