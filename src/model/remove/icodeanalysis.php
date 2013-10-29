<?php

namespace model;

interface ICodeAnalysis {
  public function errors();
  public function nrOfErrors();
}
