<?php

namespace model;

class Code {
  private $code;
  private $filename;
  private $raw;

  /**
   * @throws PHPParser_Error when code cant be parsed
   */
  public function __construct($filename, $code) {
    $this->filename = $filename;
    $this->raw = explode(PHP_EOL, $code);

    $parser = new \PHPParser_Parser(new \PHPParser_Lexer);
    $this->code = $parser->parse($code);
  }

  public function getParsedCode() {
    return $this->code;
  }

  public function getFileName() {
    return $this->filename;
  }

  public function getRawCode() {
    return $this->raw;
  }

  public function updateCode($code) {
    $this->code = $code;
  }

  public function getRow($row) {
    return $this->raw[($row == 0) ? 0 : $row - 1];
  }

  public function filter($class, $code = null) {
    if ($code == null)
      $code = $this->code;

    return array_filter($code, function ($x) use ($class) {
      return $x instanceof $class;
    });
  }

  // @todo Delete
  public function dumpParsedCode() {
    $nodeDumper = new \PHPParser_NodeDumper;
    $dump = $nodeDumper->dump($this->code);
    return '<pre>' . htmlspecialchars($dump) . '</pre>';
  }
}
