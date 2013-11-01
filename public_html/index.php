<?php

session_start();

require_once("../vendor/autoload.php");
require_once("../src/controller/application.php");

$_POST['payload'] = <<<'JSON'
{"ref":"refs/heads/master","after":"020b957c54d74b4101f8848a91f1498f0090cb3b","before":"1b6ab3f01cdeaca6b643d7840ad16d8b5c937c91","created":false,"deleted":false,"forced":false,"compare":"https://github.com/klambycom/testkod/compare/1b6ab3f01cde...020b957c54d7","commits":[{"id":"020b957c54d74b4101f8848a91f1498f0090cb3b","distinct":true,"message":"teads","timestamp":"2013-11-01T05:57:45-07:00","url":"https://github.com/klambycom/testkod/commit/020b957c54d74b4101f8848a91f1498f0090cb3b","author":{"name":"klambycom","email":"christian@klamby.com","username":"klambycom"},"committer":{"name":"klambycom","email":"christian@klamby.com","username":"klambycom"},"added":["test.php"],"removed":[],"modified":["index.php"]}],"head_commit":{"id":"020b957c54d74b4101f8848a91f1498f0090cb3b","distinct":true,"message":"teads","timestamp":"2013-11-01T05:57:45-07:00","url":"https://github.com/klambycom/testkod/commit/020b957c54d74b4101f8848a91f1498f0090cb3b","author":{"name":"klambycom","email":"christian@klamby.com","username":"klambycom"},"committer":{"name":"klambycom","email":"christian@klamby.com","username":"klambycom"},"added":["test.php"],"removed":[],"modified":["index.php"]},"repository":{"id":13983285,"name":"testkod","url":"https://github.com/klambycom/testkod","description":"Testrepositorie fÃ¶r att testa mitt 1DV408-projekt.","watchers":0,"stargazers":0,"forks":0,"fork":false,"size":76,"owner":{"name":"klambycom","email":"christian@klamby.com"},"private":false,"open_issues":0,"has_issues":true,"has_downloads":true,"has_wiki":true,"created_at":1383128376,"pushed_at":1383310669,"master_branch":"master"},"pusher":{"name":"klambycom","email":"christian@klamby.com"}}
JSON;

// @todo Delete
//var_dump(get_class_methods("PHPParser_Node_Name"));
//var_dump(get_class_methods("PHPParser_Node_Stmt_Class"));
//die();

$application = new \controller\Application();
echo $application->doRoute();
