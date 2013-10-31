<?php

namespace view;

require_once("model/ResultObserver.php");
require_once("model/CodeAnalysis.php");

class Result implements \model\ResultObserver {
  private $errors = array();

  public function error(\model\Error $error) {
    switch ($error->getErrorType()) {
      case \model\CodeErrorType::MoreThanOneClass:
        $this->errors[] = $this->moreThanOneClassError($error);
        break;

      case \model\CodeErrorType::WrongFilenameOrClassname:
        $this->errors[] = $this->wrongFilenameOrClassnameError($error);
        break;

      case \model\CodeErrorType::MissingNamespace:
        $this->errors[] = $this->missingNamespaceError($error);
        break;

      case \model\CodeErrorType::MoreThanOneNamespace:
        $this->errors[] = $this->moreThanOneNamespaceError($error);
        break;

      case \model\CodeErrorType::NonOOPCode:
        $this->errors[] = $this->nonOOPCodeError($error);
        break;

      default:
        throw new Exception();
    }
  }

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

  private function moreThanOneClassError(\model\Error $error) {
    return "<li><span class='type'>Class error:</span> mer än en klass,
            {$this->errorInfo($error)}.</li>";
  }

  private function wrongFilenameOrClassnameError(\model\Error $error) {
    return "<li><span class='type'>Class error:</span> filnamn och klass
            matchar inte, {$this->errorInfo($error)}.</li>";
  }

  private function missingNamespaceError(\model\Error $error) {
    return "<li><span class='type'>Namespace error:</span> det finns ingen
            namespace, i <span class='file'>{$error->getFilename()}</span>
            </li>";
  }

  private function moreThanOneNamespaceError(\model\Error $error) {
    return "<li><span class='type'>Namespace error:</span> mer än ett
            namespace, {$this->errorInfo($error)}.</li>";
  }

  private function nonOOPCodeError(\model\Error $error) {
    return "<li><span class='type'>OOP error:</span> det finns kod som inte är
            objekt orienterad, i <span class='file'>{$error->getFilename()}
            </span>.</li>";
  }

  private function errorInfo(\model\Error $error) {
    $code = $error->getCode();
    $file = $error->getFilename();
    $row = $error->getRow();

    return "unexpected '<pre>$code</pre>' i <span class='file'>$file</span> på
            rad <span class='row'>$row</span>";
  }
}
