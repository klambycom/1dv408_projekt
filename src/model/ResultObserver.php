<?php

namespace model;

interface ResultObserver {
  public function showErrors(CodeAnalysis $result);
}
