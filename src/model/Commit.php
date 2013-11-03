<?php

namespace model;

require_once("../src/model/Code.php");

class Commit {
  private $id;
  private $timestamp;
  private $removed;
  private $repository;
  private $branch;
  private $code = array();
  private $changes = array();

  public function __construct($id, $timestamp, $added, $removed, $modified) {
    $this->id = $id;
    $this->timestamp = $timestamp;
    $this->removed = $removed;
    $this->changes = array_merge($added, $modified);
  }

  public function getId() {
    return $this->id;
  }

  public function getTimestamp() {
    return $this->timestamp;
  }

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

  public function getFiles() {
    return array_merge($this->removed, $this->changes);
  }

  // @todo Remove?
  public function getRemovedFiles() {
    return $this->removed;
  }

  public function setRepositoryInformation($repository, $branch) {
    $this->repository = $repository;
    $this->branch = $branch;
  }

  // @todo Remove? Should'nt be here anyway.
  public function getUrl() {
    return "https://github.com/{$this->repository}/commit/{$this->id}";
  }

  // @todo Remove?
  public function __toString() {
    return "<p>Id: {$this->id}, Timestamp: {$this->timestamp}</p>";
  }
}
