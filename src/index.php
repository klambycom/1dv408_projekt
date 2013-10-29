<?php

//var_dump(get_class_methods("PHPParser_Node_Name"));
//var_dump(get_class_methods("PHPParser_Node_Stmt_Class"));
//die();

require_once("controller/application.php");

$application = new \controller\Application();
echo $application->doApplication();
