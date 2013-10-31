<?php

namespace model;

require_once("model/Error.php");
require_once("model/Repository.php");
require_once("model/DataAccessLayer.php");

class ErrorDAL extends DataAccessLayer {
  private $repository;
  private $errors = array();

  public function __construct(Repository $repository) {
    parent::__construct();
    $this->repository = $repository;
  }

  public function setup() {
    $query = $this->pdo->prepare("CREATE TABLE `error` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `repository_id` int(50) NOT NULL,
      `filename` varchar(500) COLLATE utf8_bin NOT NULL,
      `error_type` int(11) NOT NULL,
      `row` int(11) NOT NULL,
      `code` text COLLATE utf8_bin NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin");
    $query->execute();
  }

  public function create(Error $error) {
    $this->errors[] = $error;
  }

  public function remove($errors) {
    $remove = "DELETE FROM `error` WHERE `repository_id` = :id AND `filename` = :filename";

    $files = array_unique(array_map(function ($x) {
      return $x->getFilename();
    }, $errors));

    foreach ($files as $file) {
      $query = $this->pdo->prepare($remove);
      $query->execute(array("id"       => $this->repository->getId(),
                            "filename" => $file));
    }
  }

  public function find(Repository $repository) {
    // Error(Code $code, $errorType, $row = 0) or
    // SimpleError($filename, $error_type, $row, $code)
  }

  public function __destruct() {
    $remove = "DELETE FROM `error` WHERE `repository_id` = :id AND `filename` = :filename";
    $add = "INSERT INTO `error` (
              `repository_id`,
              `filename`,
              `error_type`,
              `row`,
              `code`
            ) VALUES (
              :repository_id,
              :filename,
              :error_type,
              :row,
              :code
            )";

    if (!empty($this->errors)) {
      $this->remove($this->errors);

      foreach ($this->errors as $error) {
        $query = $this->pdo->prepare($add);
        $query->execute(array("repository_id" => $this->repository->getId(),
                              "filename"      => $error->getFilename(),
                              "error_type"    => $error->getErrorType(),
                              "row"           => $error->getRow(),
                              "code"          => $error->getCode()));
      }
    }
  }
}
