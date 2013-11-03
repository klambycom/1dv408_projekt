<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

/*
$_POST['payload'] = <<<'JSON'
{"ref":"refs/heads/master","after":"e0f7cec541492ec53dbcf314fa7f502a5350df1a","before":"705a3956afe6d44a68699de62353b15cf0490bb0","created":false,"deleted":false,"forced":false,"compare":"https://github.com/klambycom/1dv408_projekt/compare/705a3956afe6...e0f7cec54149","commits":[{"id":"e0f7cec541492ec53dbcf314fa7f502a5350df1a","distinct":true,"message":"Comments","timestamp":"2013-11-03T11:51:27-08:00","url":"https://github.com/klambycom/1dv408_projekt/commit/e0f7cec541492ec53dbcf314fa7f502a5350df1a","author":{"name":"klambycom","email":"christian@klamby.com","username":"klambycom"},"committer":{"name":"klambycom","email":"christian@klamby.com","username":"klambycom"},"added":[],"removed":[],"modified":["src/model/AuthenticateUser.php"]}],"head_commit":{"id":"e0f7cec541492ec53dbcf314fa7f502a5350df1a","distinct":true,"message":"Comments","timestamp":"2013-11-03T11:51:27-08:00","url":"https://github.com/klambycom/1dv408_projekt/commit/e0f7cec541492ec53dbcf314fa7f502a5350df1a","author":{"name":"klambycom","email":"christian@klamby.com","username":"klambycom"},"committer":{"name":"klambycom","email":"christian@klamby.com","username":"klambycom"},"added":[],"removed":[],"modified":["src/model/AuthenticateUser.php"]},"repository":{"id":13804228,"name":"1dv408_projekt","url":"https://github.com/klambycom/1dv408_projekt","description":"","watchers":0,"stargazers":0,"forks":0,"fork":false,"size":492,"owner":{"name":"klambycom","email":"christian@klamby.com"},"private":false,"open_issues":0,"has_issues":true,"has_downloads":true,"has_wiki":true,"language":"CSS","created_at":1382536759,"pushed_at":1383508292,"master_branch":"master"},"pusher":{"name":"klambycom","email":"christian@klamby.com"}}
JSON;
*/

/*
$pdo = new \PDO("mysql:host=mysql462.loopia.se;dbname=klamby_com", "1dv408@k90053", "ws1fur2");
$q = $pdo->prepare("INSERT INTO `githubtest` (`payload`) VALUES (:payload)");
$q->execute(array("payload" => serialize($_POST)));
 */

session_start();

require_once("../vendor/autoload.php");
require_once("../src/controller/Application.php");

$application = new \controller\Application();
echo $application->doRoute();
