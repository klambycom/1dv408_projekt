<?php

require_once("controller/application.php");

$application = new \controller\Application();
echo $application->doApplication();
