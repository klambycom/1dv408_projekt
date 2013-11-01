<?php

namespace view;

require_once("../src/model/ResultObserver.php");
require_once("../src/model/CodeAnalysis.php");
require_once("../src/view/Application.php");

class Result extends Application implements \model\ResultObserver {
  private $errors = array();

  public function showResultPage(\model\Repository $repo, $errors) {
    if (count($errors) > 0) {
      $errorsList = $this->getErrorsList($errors);
    } else {
      $errorsList = "<p id='no-errors'>Inge brott mot kodkvalitetskraven</p>";
    }

    return $this->html("{$this->repositoryInfo($repo)}
                        {$errorsList}");
  }

  public function error(\model\Error $error) {
    $this->errors[] = $this->getError($error);
  }

  // @todo Delete?
  public function showRapport(\model\CodeAnalysisFacade $tests) {
    $namespace = $tests->getNamespace();
    $class = $tests->getClassName();

    return "<h1>Resusltat för $namespace\\$class</h1>
            <ul class='error-list'>
              " . implode("", $this->errors) . "
              <li class='summary'>Totalt 10 brott mot kodkvalitetskraven</li>
            </ul>
            <hr>";
  }

  private function getErrorsList($errors) {
    $errorStrs = array();
    foreach ($errors as $error) {
      $errorStrs[] = $this->getError($error);
    }
  
    return "<ul id='error-list'>" . implode("", $errorStrs) . "
              <li class='summary'>
                Totalt " . count($errors) . " brott mot kodkvalitetskraven
              </li>
            </ul>";
  }

  private function getError(\model\Error $error) {
    switch ($error->getErrorType()) {
      case \model\CodeErrorType::MoreThanOneClass:
        return $this->moreThanOneClassError($error);

      case \model\CodeErrorType::WrongFilenameOrClassname:
        return $this->wrongFilenameOrClassnameError($error);

      case \model\CodeErrorType::MissingNamespace:
        return $this->missingNamespaceError($error);

      case \model\CodeErrorType::MoreThanOneNamespace:
        return $this->moreThanOneNamespaceError($error);

      case \model\CodeErrorType::NonOOPCode:
        return $this->nonOOPCodeError($error);

      case \model\CodeErrorType::MethodTooLong:
        return $this->methodTooLongError($error);

      case \model\CodeErrorType::LineTooLong:
        return $this->lineTooLongError($error);
    }
  }

  private function moreThanOneClassError(\model\Error $error) {
    return "<li><span class='type'>Class error:</span> mer än en klass,
            oväntad {$this->errorInfo($error)}.</li>";
  }

  private function wrongFilenameOrClassnameError(\model\Error $error) {
    return "<li><span class='type'>Class error:</span> filnamn och klass
            matchar inte, oväntad {$this->errorInfo($error)}.</li>";
  }

  private function missingNamespaceError(\model\Error $error) {
    return "<li><span class='type'>Namespace error:</span> det finns inget
            namespace, i <span class='file'>{$error->getFilename()}</span>.
            </li>";
  }

  private function moreThanOneNamespaceError(\model\Error $error) {
    return "<li><span class='type'>Namespace error:</span> mer än ett
            namespace, oväntad {$this->errorInfo($error)}.</li>";
  }

  private function nonOOPCodeError(\model\Error $error) {
    return "<li><span class='type'>OOP error:</span> det finns kod som inte är
            objekt-orienterad, i
            <span class='file'>{$error->getFilename()}</span>.</li>";
  }

  private function methodTooLongError(\model\Error $error) {
    return "<li><span class='type'>Method error:</span> en metod bör vara
            mycket mindre än 30 rader, i {$this->errorInfo($error)}.</li>";
  }

  private function lineTooLongError(\model\Error $error) {
    return "<li><span class='type'>Length error:</span> en rad får inte
            vara mer än 80 tecken lång, raden {$this->errorInfo($error)}.
            </li>";
  }

  private function errorInfo(\model\Error $error) {
    $code = trim($error->getCode());
    $file = $error->getFilename();
    $row = $error->getRow();

    return "'<pre>$code</pre>' i <span class='file'>$file</span> på
            rad <span class='row-nr'>$row</span>";
  }

  private function repositoryInfo(\model\Repository $repo) {
    $githubUser = "<a href='https://github.com/{$repo->getOwner()}'>
                     {$repo->getOwner()}</a>";
    $githubRepo = "
      <a href='https://github.com/{$repo->getOwner()}/{$repo->getName()}'>
        {$repo->getName()}</a>";

    return "<div id='repository'>
              <h2>{$githubUser} / <strong>{$githubRepo}</strong></h2>
              <p>
                Pushades senast
                <span class='pushed-at'>{$repo->getPushedAt()}</span>
              </p>
            </div>";
  }
}
