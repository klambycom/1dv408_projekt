<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

session_start();

require_once("../vendor/autoload.php");
require_once("../src/controller/Application.php");

$application = new \controller\Application();
echo $application->doRoute();
