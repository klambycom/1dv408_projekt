<?php

namespace model;

final class CodeErrorType {
  /**
   * @const int
   */
  const MoreThanOneClass = 0;

  /**
   * @const int
   */
  const NonOOPCode = 1;

  /**
   * @const int
   */
  const WrongFilenameOrClassname = 2;

  /**
   * @const int
   */
  const MissingNamespace = 3;

  /**
   * @const int
   */
  const MoreThanOneNamespace = 4;

  /**
   * @const int
   */
  const MethodTooLong = 5;

  /**
   * @const int
   */
  const LineTooLong = 6;

  private function __construct() {}
}
