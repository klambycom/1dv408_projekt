<?php

namespace model;

class Error {
  private $fileName;
  private $row;
  private $className;
  private $code;

  public function __construct($className, $fileName, $row, $badCode) {
    $this->fileName = $fileName;
    $this->className = $className;
    $this->row = $row;
    $this->code = $badCode;
  }

  public function getClassName() {
    return $this->className();
  }

  public function __toString($string = "") {
    if (empty($string)) {
      return "$this->className [$this->filename], row $this->row: $this->code";
    }

    // @todo
    //ex. string = "{filename} row {row}: {code} borde blablabla"
  }
}

class CodeAnalysis {
  private $listeners = array();
  private $errors = array();
  protected $code;

  public function __construct(Code $code) {
    $this->code = $code;
  }

  public function nrOfErrors() {
    return count($this->errors);
  }

  public function subscribe(CodeResultObserver $listener) {
    $this->listeners[] = $listener;
  }

  protected function publish() {
    foreach ($this->listeners as $key => $listener) {
      $listener->showErrors($this->errors);
    }
  }

  protected function addError($row, $badCode) {
    $this->errors[] = new Error("classname", $this->code->getFileName(), $row, $badCode);
  }
}

class CodeAnalysisFacade extends CodeAnalysis {
  private $analysises = array();

  public function __construct(Code $code) {
    $this->analysises['namespace'] = new FindNamespace($code);
  }

  public function getNamespace() {
    $namespace = $this->analysises['namespace'];
    return $namespace->__toString();
  }

  public function subscribe(CodeResultObserver $listener) {
    foreach ($this->analysises as $key => $analysis) {
      $analysis->subscribe($listener);
    }
  }

  public function nrOfErrors() {
    $count = 0;

    foreach ($this->analysis as $key => $analysis) {
      $count += $analysis->nrOfErrors();
    }

    return $count;
  }
}

class FindNamespace extends CodeAnalysis {
  private $namespace;

  public function findErrors() {
    //$namespaces = $this->findNamespaces($this->code->getParsedCode());
    $namespaces = $this->findNamespaces($this->code);
    $nrOfNamespaces = count($namespaces);

    if ($nrOfNamespaces == 1) {
      $tmp = $namespaces[0];
      $this->namespace = $tmp->name->__toString();
    } else if ($nrOfNamespaces < 1) {
      // @todo Missing namespace
    } else if ($nrOfNamespaces > 1) {
      // @todo More than one namespace
    }
  }

  public function __toString() {
    return $this->namespace;
  }

  private function findNamespaces(Code $code) {
    return array_filter($code->getParsedCode(), function ($x) {
      return $x instanceof \PHPParser_Node_Stmt_Namespace;
    });
  }
}
