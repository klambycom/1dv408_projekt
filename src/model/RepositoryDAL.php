<?php

namespace model;

require_once("model/Repository.php");
require_once("model/DataAccessLayer.php");

class RepositoryDAL extends DataAccessLayer {
  public function setup() {
    $query = $this->pdo->prepare("CREATE TABLE  `repository` (
                                  `id` INT( 50 ) NOT NULL ,
                                  `name` VARCHAR( 50 ) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ,
                                  `owner` VARCHAR( 50 ) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ,
                                  `private` TINYINT( 1 ) NOT NULL ,
                                  `created_at` DATE NOT NULL ,
                                  `pushed_at` DATE NOT NULL ,
                                  UNIQUE (
                                  `id`
                                  )
                                  ) ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_bin");
    $query->execute();
  }

  public function find(Repository $repository) {
    $query = $this->pdo->prepare("SELECT * FROM `repository` WHERE `id` = :id LIMIT 1");
    $query->execute(array("id" => $repository->getId()));
    $result = $query->fetch(\PDO::FETCH_ASSOC);

    if ($query->rowCount() < 1)
      throw new \Exception("no matching repository");

    return new Repository($result["id"],
                          $result["name"],
                          $result["owner"],
                          $result["private"],
                          $result["created_at"],
                          $result["pushed_at"]);
  }

  public function createOrUpdate(Repository $repository) {
    $query = $this->pdo->prepare("SELECT * FROM `repository` WHERE id = :id LIMIT 1");
    $query->execute(array(":id" => $repository->getId()));
    $result = $query->fetch(\PDO::FETCH_ASSOC);

    if ($query->rowCount() < 1) {
      $this->create($repository);
    } else {
      $this->update($repository);
    }
  }

  private function create(Repository $repository) {
    $query = $this->pdo->prepare("INSERT INTO `repository` (
                                    `id`,
                                    `name`,
                                    `owner`,
                                    `private`,
                                    `created_at`,
                                    `pushed_at`
                                  ) VALUES (
                                    :id,
                                    :name,
                                    :owner,
                                    :private,
                                    :created_at,
                                    :pushed_at
                                  )");
    $query->execute(array("id"         => $repository->getId(),
                          "name"       => $repository->getName(),
                          "owner"      => $repository->getOwner(),
                          "private"    => $repository->isPrivate(),
                          "created_at" => $repository->getCreatedAt(),
                          "pushed_at"  => $repository->getPushedAt()));
  }

  private function update(Repository $repository) {
    $query = $this->pdo->prepare("UPDATE `repository` SET
                                    `name` = :name,
                                    `owner` = :owner,
                                    `private` = :private,
                                    `pushed_at` = :pushed_at
                                  WHERE `id` = :id");

    $query->execute(array("id"         => $repository->getId(),
                          "name"       => $repository->getName(),
                          "owner"      => $repository->getOwner(),
                          "private"    => $repository->isPrivate(),
                          "pushed_at"  => $repository->getPushedAt()));
  }
}
