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

  public function __toString(/*$format = ""*/) {
    //$format = func_get_arg(0) or $format = "";
    //if (empty($format)) {
      return "$this->className [$this->filename], row $this->row: $this->code";
    //}

    // @todo
    //ex. string = "{filename} row {row}: {code} borde blablabla"
  }
}
