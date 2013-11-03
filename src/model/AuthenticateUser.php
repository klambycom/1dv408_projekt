<?php

namespace model;

require_once("../src/model/Settings.php");

class AuthenticateUser extends User {
  /**
   * @param string $code Code from Github
   */
  public function __construct($code) {
    $matches = array();
    preg_match('/access_token=(.*)&scope=(.*)&token_type=(.*)/',
               $result, $matches);

    if (empty($matches))
      throw new \Exception();

    $_SESSION[$this->tokenName] = $matches[1];

    parent::__construct();
  }

  /**
   * @return String
   */
  private function postToGithub() {
    $settings = new Settings();

    $url = "https://github.com/login/oauth/access_token";
    $data = array(
      'client_id'     => $settings->githubId(),
      'client_secret' => $settings->githubToken(),
      'code'          => $code
    );
    $options = array(
      'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => \http_build_query($data)
      )
    );

    $context  = stream_context_create($options);
    return file_get_contents($url, false, $context);
  }
}
