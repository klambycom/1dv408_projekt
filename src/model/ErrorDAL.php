<?php

namespace model;

require_once("../src/model/Error.php");
require_once("../src/model/SimpleError.php");
require_once("../src/model/Repository.php");
require_once("../src/model/DataAccessLayer.php");

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

  public function removeAll($errors) {
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

  public function deleteFiles($files) {
    foreach ($files as $file) {
      $query = $this->pdo->prepare("DELETE FROM `error`
                                    WHERE `repository_id` = :id AND
                                          `filename` = :filename");

      $query->execute(array("id"       => $this->repository->getId(),
                            "filename" => $file));
    }
  }

  public function all() {
    $query = $this->pdo->prepare("SELECT
                                    `filename`,
                                    `error_type`,
                                    `row`,
                                    `code`
                                  FROM `error` WHERE `repository_id` = :id");
    $query->execute(array("id" => $this->repository->getId()));
    $result = $query->fetchAll(\PDO::FETCH_FUNC, function ($filename,
                                                           $error_type,
                                                           $row,
                                                           $code) {
      return new SimpleError($filename, $error_type, $row, $code);
    });

    if ($query->rowCount() < 1)
      throw new \Exception("no matching repository");

    return $result;
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
      $this->removeAll($this->errors);

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
