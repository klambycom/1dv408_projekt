<?php

session_start();

require_once("../vendor/autoload.php");
require_once("../src/controller/Application.php");

$application = new \controller\Application();
echo $application->doRoute();
