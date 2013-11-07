<?php

namespace model;

require_once("../src/model/NoTokenException.php");
require_once("../src/model/InvalidTokenException.php");

class User {
  /**
   * @var \Github\Client
   */
  private $client;

  /**
   * @var string
   */
  protected $tokenName = 'token';

  /**
   * @var string
   */
  private $id;

  /**
   * @var string
   */
  private $username;

  /**
   * @var string
   */
  private $gravatar;

  /**
   * @var string
   */
  private $url;

  /**
   * @var string
   */
  private $name;

  /**
   * @var string
   */
  private $bio;

  /**
   * @throws \model\NoTokenException when no session
   * @throws \model\InvalidTokenException when invalid token in session
   */
  public function __construct() {
    if (!isset($_SESSION[$this->tokenName]))
      throw new NoTokenException();

    try {
      $this->client = new \Github\Client();
      
      $this->client->authenticate($_SESSION[$this->tokenName],
                                  \Github\Client::AUTH_HTTP_TOKEN);

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

  /**
   * @return string
   */
  public function getId() {
    return $this->id;
  }

  /**
   * @return string
   */
  public function getUsername() {
    return $this->username;
  }

  /**
   * @param int $size
   * @param string $default
   * @return string
   */
  public function getGravatar($size = 285, $default = 'mm') {
    $base = 'http://www.gravatar.com/avatar';
    return "{$base}/{$this->gravatar}?s={$size}&d={$default}";
  }

  /**
   * @return string
   */
  public function getUrl() {
    return $this->url;
  }

  /**
   * @return string
   */
  public function getName() {
    return $this->name;
  }

  /**
   * @return string
   */
  public function getBio() {
    return $this->bio;
  }
}
