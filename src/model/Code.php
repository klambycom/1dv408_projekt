<?php

namespace model;

class Code {
  /**
   * @var array
   */
  private $code;

  /**
   * @var string
   */
  private $filename;

  /**
   * @var array
   */
  private $raw;

  /**
   * @param string $filename
   * @param string $code
   * @throws PHPParser_Error when code cant be parsed
   */
  public function __construct($filename, $code) {
    $this->filename = $filename;
    $this->raw = explode(PHP_EOL, $code);

    $parser = new \PHPParser_Parser(new \PHPParser_Lexer);
    $this->code = $parser->parse($code);
  }

  /**
   * @return array
   */
  public function getParsedCode() {
    return $this->code;
  }

  /**
   * @return string
   */
  public function getFileName() {
    return $this->filename;
  }

  /**
   * @return array
   */
  public function getRawCode() {
    return $this->raw;
  }

  /**
   * @param array $code
   */
  public function updateCode($code) {
    $this->code = $code;
  }

  /**
   * @param int $row
   * @return string
   */
  public function getRow($row) {
    return $this->raw[($row == 0) ? 0 : $row - 1];
  }

  /**
   * @param string $class
   * @param array $code Optional
   * @return array
   */
  public function filter($class, $code = null) {
    if ($code == null)
      $code = $this->code;

    return array_filter($code, function ($x) use ($class) {
      return $x instanceof $class;
    });
  }
}
