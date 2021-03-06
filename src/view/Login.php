<?php

namespace view;

require_once("../src/view/Application.php");

class Login extends Application {
  /**
   * @return string
   */
  public function firstPage() {
    return $this->html("<h1>Hello, World</h1>");
  }

  /**
   * @param string $clientId
   * @return string
   */
  public function login($clientId) {
    return $this->html("
      <div class='jumbotron'>
        <h1>Information om tjänsten</h1>
        <p>text...</p>
        <p>
          <a
            href='https://github.com/login/oauth/authorize?client_id=$clientId'
            id='login-btn'>
            Logga in
          </a>
        </p>
      </div>");
  }

  /**
   * @return boolean
   */
  public function authCodeIsSet() {
    return isset($_GET['code']);
  }

  /**
   * @return string
   */
  public function getAuthCode() {
    return $_GET['code'];
  }

  /**
   * @param \model\User $user
   * @param array
   * @return string
   */
  public function userPage(\model\User $user, $repositories) {
    if (empty($repositories)) {
      $repos = "Du måste lägga till repositiorire!";
    } else {
      $repos = "";
      foreach ($repositories as $repo) {
        $repos .= $this->repositoryInfo($repo);
      }
    }

    return $this->html("
      {$this->userInfo($user)}
      <div id='repositories'>
        <h2>Dina repositorien</h2>
        <p>Om du vill se ett repositorie här måste du lägga till en service
           hook med adressen <code>http://kodkvalitet.klamby.com</code>. Sen
           kommer vi kolla kodkvaliteten varje gång du pushar till
           master-branchen på Github.</p>
        $repos
      </div>");
  }

  /**
   * @param \model\User $user
   * @return string
   */
  private function userInfo(\model\User $user) {
    return "<aside id='user-info'>
              <img src='{$user->getGravatar()}' id='user-img'>
              <h1>{$user->getName()}</h1>
              <h2>{$user->getUsername()}</h2>
              <p>{$user->getBio()}</p>
              <a href='{$user->getUrl()}'>{$user->getUrl()}</a>
            </aside>";
  }

  /**
   * @param \model\Repository $repo
   * @return string
   */
  private function repositoryInfo(\model\Repository $repo) {
    return "<div class='repository'>
              <div class='title'>
                <h3>
                  <img src='/?controller={$repo->getId()}.png'>
                  <a href='/?controller=resultat&page={$repo->getId()}'>
                  {$repo->getName()}
                  </a>
                </h3>
                <p class='push-dates'>
                  skapades
                  <span class='created_at'>{$repo->getcreatedat()}</span>,
                  och pushades senast
                  <span class='pushed-at'>{$repo->getpushedat()}</span>
                </p>
              </div>
              <div class='body'>
                <p class='img-link'>
                  Adress till bild som visar resultat är
                  http://kodkvalitet.klamby.com/?controller={$repo->getId()}.png
                </p>
              </div>
            </div>";
  }
}
