<?php

namespace model;

require_once("../src/model/Repository.php");
require_once("../src/model/DataAccessLayer.php");

class RepositoryDAL extends DataAccessLayer {
  /**
   * Setup repository database.
   */
  public function setup() {
    $query = $this->pdo->prepare("
      CREATE TABLE  `repository` (
        `id` INT( 50 ) NOT NULL ,
        `name` VARCHAR( 50 ) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ,
        `owner` VARCHAR( 50 ) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ,
        `private` TINYINT( 1 ) NOT NULL ,
        `created_at` DATE NOT NULL ,
        `pushed_at` DATE NOT NULL ,
      UNIQUE (`id`)
      ) ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_bin");
    $query->execute();
  }

  /**
   * @param \model\Repository $repository
   * @return \model\Repository
   */
  public function find(Repository $repository) {
    $query = $this->pdo->prepare("SELECT * FROM `repository`
                                  WHERE `id` = :id LIMIT 1");
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

  /**
   * @param string $name
   * @return \model\Repository
   */
  public function findById($id) {
    $query = $this->pdo->prepare("SELECT * FROM `repository`
                                  WHERE `id` = :id LIMIT 1");
    $query->execute(array("id" => $id));
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

  /**
   * @param \model\User $user
   * @return \model\Repository
   */
  public function findAllByOwner(User $user) {
    $query = $this->pdo->prepare("SELECT * FROM `repository`
                                  WHERE `owner` = :owner");
    $query->execute(array("owner" => $user->getUsername()));
    $result = $query->fetchAll(\PDO::FETCH_FUNC, function ($id,
                                                           $name,
                                                           $owner,
                                                           $private,
                                                           $created_at,
                                                           $pushed_at) {
      return new Repository($id,
                            $name,
                            $owner,
                            $private,
                            $created_at,
                            $pushed_at);
    });

    if ($query->rowCount() < 1)
      throw new \Exception("no matching repository");

    return $result;
  }

  /**
   * @param \model\Repository $repository
   * @return \model\Repository
   */
  public function createOrUpdate(Repository $repository) {
    $query = $this->pdo->prepare("SELECT * FROM `repository`
                                  WHERE id = :id LIMIT 1");
    $query->execute(array(":id" => $repository->getId()));
    $result = $query->fetch(\PDO::FETCH_ASSOC);

    if ($query->rowCount() < 1) {
      $this->create($repository);
    } else {
      $this->update($repository);
    }
  }

  /**
   * @param string $name
   * @return int Number of errors
   */
  public function nrOfErrors($id) {
    $query = $this->pdo->prepare("SELECT COUNT(*) AS rows FROM `repository`
                                  INNER JOIN `error`
                                  ON `repository`.`id` = `error`.`repository_id`
                                  WHERE `repository`.`id` = :id");
    $query->execute(array("id" => $id));
    $result = $query->fetch(\PDO::FETCH_ASSOC);

    return $result["rows"];
  }

  /**
   * @param \model\Repository $repository
   */
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

  /**
   * @param \model\Repository $repository
   */
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
