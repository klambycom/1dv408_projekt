<?php

namespace model;

class NoTokenException extends \Exception {
}

class InvalidTokenException extends \Exception {
}

class User {
  private $client;
  protected $tokenName = 'token';

  private $id;
  private $username;
  private $gravatar;
  private $url;
  private $name;
  private $bio;

  public function __construct() {
    if (!isset($_SESSION[$this->tokenName]))
      throw new NoTokenException();

    try {
      $this->client = new \Github\Client(
        new \Github\HttpClient\CachedHttpClient(array('cache_dir' => '/tmp/github-api-cache'))
      );
      
      $this->client->authenticate($_SESSION[$this->tokenName], \Github\Client::AUTH_HTTP_TOKEN);

      $data = $this->client->api('current_user')->show();

      $this->id = $data['id'];
      $this->username = $data['login'];
      $this->gravatar = $data['gravatar_id'];
      $this->url = $data['html_url'];
      $this->name = $data['name'];
      $this->bio = $data['bio'];
    } catch (\Exception $e) {
      unset($_SESSION[$this->tokenName]);
      throw new InvalidTokenException();
    }
  }

  public function getId() {
    return $this->id;
  }

  public function getUsername() {
    return $this->username;
  }

  public function getGravatar($size = 285, $default = 'mm') {
    $base = 'http://www.gravatar.com/avatar';
    return "{$base}/{$this->gravatar}?s={$size}&d={$default}";
  }

  public function getUrl() {
    return $this->url;
  }

  public function getName() {
    return $this->name;
  }

  public function getBio() {
    return $this->bio;
  }
}
