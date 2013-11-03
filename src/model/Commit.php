<?php

namespace model;

require_once("../src/model/Code.php");

class Commit {
  /**
   * @var int
   */
  private $id;

  /**
   * @var int
   */
  private $timestamp;

  /**
   * @var array
   */
  private $removed;

  /**
   * @var int
   */
  private $repository;

  /**
   * @var string
   */
  private $branch;

  /**
   * @var array
   */
  private $code = array();

  /**
   * @var array
   */
  private $changes = array();

  /**
   * @param int $id
   * @param int $timestamp
   * @param array $added
   * @param array $removed
   * @param array $modified
   */
  public function __construct($id, $timestamp, $added, $removed, $modified) {
    $this->id = $id;
    $this->timestamp = $timestamp;
    $this->removed = $removed;
    $this->changes = array_merge($added, $modified);
  }

  /**
   * @return int
   */
  public function getId() {
    return $this->id;
  }

  /**
   * @return int
   */
  public function getTimestamp() {
    return $this->timestamp;
  }

  /**
   * @return array of \model\Code
   */
  public function getCode() {
    $code = array();
    $url = "https://raw.github.com/{$this->repository}/{$this->branch}/";

    foreach ($this->changes as $file) {
      if (\preg_match('/(.*)\.php/', $file)) {
        $raw = file_get_contents("{$url}{$file}");
        $code[] = new \model\Code($file, $raw);
      }
    }

    return $code;
  }

  /**
   * @return array of filenames
   */
  public function getFiles() {
    return array_merge($this->removed, $this->changes);
  }

  /**
   * @param string $repository
   * @param string $branch
   */
  public function setRepositoryInformation($repository, $branch) {
    $this->repository = $repository;
    $this->branch = $branch;
  }
}
