<?php

/*
$_POST['payload'] = <<<'JSON'
{"ref":"refs/heads/master","after":"bddce278adcea901505810487ea04163fa4ae34d","before":"d1be11916d61c1876587343f79bb6d9e27c6b923","created":false,"deleted":false,"forced":false,"compare":"https://github.com/klambycom/1dv408_projekt/compare/d1be11916d61...bddce278adce","commits":[{"id":"bddce278adcea901505810487ea04163fa4ae34d","distinct":true,"message":"Better code quality","timestamp":"2013-11-03T10:06:38-08:00","url":"https://github.com/klambycom/1dv408_projekt/commit/bddce278adcea901505810487ea04163fa4ae34d","author":{"name":"klambycom","email":"christian@klamby.com","username":"klambycom"},"committer":{"name":"klambycom","email":"christian@klamby.com","username":"klambycom"},"added":[],"removed":[],"modified":["src/model/RepositoryDAL.php"]}],"head_commit":{"id":"bddce278adcea901505810487ea04163fa4ae34d","distinct":true,"message":"Better code quality","timestamp":"2013-11-03T10:06:38-08:00","url":"https://github.com/klambycom/1dv408_projekt/commit/bddce278adcea901505810487ea04163fa4ae34d","author":{"name":"klambycom","email":"christian@klamby.com","username":"klambycom"},"committer":{"name":"klambycom","email":"christian@klamby.com","username":"klambycom"},"added":[],"removed":[],"modified":["src/model/RepositoryDAL.php"]},"repository":{"id":13804228,"name":"1dv408_projekt","url":"https://github.com/klambycom/1dv408_projekt","description":"","watchers":0,"stargazers":0,"forks":0,"fork":false,"size":432,"owner":{"name":"klambycom","email":"christian@klamby.com"},"private":false,"open_issues":0,"has_issues":true,"has_downloads":true,"has_wiki":true,"language":"CSS","created_at":1382536759,"pushed_at":1383502007,"master_branch":"master"},"pusher":{"name":"klambycom","email":"christian@klamby.com"}}
JSON;
*/

error_reporting(E_ALL);
ini_set('display_errors', '1');

session_start();

require_once("../vendor/autoload.php");
require_once("../src/controller/Application.php");

$application = new \controller\Application();
echo $application->doRoute();
