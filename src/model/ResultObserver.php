<?php

namespace model;

interface ResultObserver {
  public function error(Error $error);
}
