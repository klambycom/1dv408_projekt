<?php

namespace model;

interface ResultObserver {
  /**
   * @param \model\Error $error
   */
  public function error(Error $error);
}
