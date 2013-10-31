<?php

/*
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once("model/GithubtestDAL.php");

if (isset($_POST['payload'])) {
  $g = new \model\GithubtestDAL();
  $g->add($_POST["payload"]);
} else {
  echo "Du använder tjänsten på fel sätt!";
}

die();
 */

//var_dump(get_class_methods("PHPParser_Node_Name"));
//var_dump(get_class_methods("PHPParser_Node_Stmt_Class"));
//die();

require_once("controller/application.php");

$application = new \controller\Application();
echo $application->doApplication();

/*
$_POST['payload'] = <<<'JSON'
{
  "ref":"refs/heads/master",
  "after":"1b6ab3f01cdeaca6b643d7840ad16d8b5c937c91",
  "before":"a70aef0669fc4771b9632ee39869151e64a594df",
  "created":false,
  "deleted":false,
  "forced":false,
  "compare":"https://github.com/klambycom/testkod/compare/a70aef0669fc...1b6ab3f01cde",
  "commits": [
    {
      "id":"1b6ab3f01cdeaca6b643d7840ad16d8b5c937c91",
      "distinct":true,
      "message":"Added firts php-file",
      "timestamp":"2013-10-30T03:25:34-07:00",
      "url":"https://github.com/klambycom/testkod/commit/1b6ab3f01cdeaca6b643d7840ad16d8b5c937c91",
      "author": {
        "name":"klambycom",
        "email":"christian@klamby.com",
        "username":"klambycom"
      },
      "committer":{
        "name":"klambycom",
        "email":"christian@klamby.com",
        "username":"klambycom"
      },
      "added":["index.php"],
      "removed":[],
      "modified":[]
    }
  ],
  "head_commit": {
    "id":"1b6ab3f01cdeaca6b643d7840ad16d8b5c937c91",
    "distinct":true,
    "message":"Added firts php-file",
    "timestamp":"2013-10-30T03:25:34-07:00",
    "url":"https://github.com/klambycom/testkod/commit/1b6ab3f01cdeaca6b643d7840ad16d8b5c937c91",
    "author":{
      "name":"klambycom",
      "email":"christian@klamby.com",
      "username":"klambycom"
    },
    "committer":{
      "name":"klambycom",
      "email":"christian@klamby.com",
      "username":"klambycom"
    },
    "added":["index.php"],
    "removed":[],
    "modified":[]
  },
  "repository":{
    "id":13983285,
    "name":"testkod",
    "url":"https://github.com/klambycom/testkod",
    "description":"Testrepositorie fÃ¶r att testa mitt 1DV408-projekt.",
    "watchers":0,
    "stargazers":0,
    "forks":0,
    "fork":false,
    "size":76,
    "owner":{
      "name":"klambycom",
      "email":"christian@klamby.com"
    },
    "private":false,
    "open_issues":0,
    "has_issues":true,
    "has_downloads":true,
    "has_wiki":true,
    "created_at":1383128376,
    "pushed_at":1383128738,
    "master_branch":"master"
  },
  "pusher":{
    "name":"klambycom",
    "email":"christian@klamby.com"
  }
}
JSON;

require_once("model/Repository.php");
require_once("model/Commit.php");
require_once("view/Github.php");

$github = new \view\Github();

if ($github->isUsedCorrect()) {
  //$g = new \model\GithubtestDAL();
  //$g->add($_POST["payload"]);

  $repository = new \model\Repository($github->getId(),
                                      $github->getName(),
                                      $github->getOwner(),
                                      $github->isPrivate(),
                                      $github->getCreatedAt(),
                                      $github->getPushedAt(),
                                      $github->getMaster(),
                                      $github->getRefBranch());

  foreach ($github->getCommitsJson() as $commit) {
    $repository->addCommit(new \model\Commit($commit->{'id'},
                                             $commit->{'timestamp'},
                                             $commit->{'added'},
                                             $commit->{'removed'},
                                             $commit->{'modified'}));
  }

  echo $repository;
  //$repository->tmpGetCode();
  //echo "<hr>";
  //var_dump($repository);
} else {
  echo "Du använder tjänsten på fel sätt!";
}

//var_dump(json_decode($_POST['payload']));
 */
