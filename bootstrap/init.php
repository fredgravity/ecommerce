<?php

//START SESSION IF NOT ALREADY STARTED
if(!isset($_SESSION)) session_start();



//REQUIRE THE _ENV PHP FILE IN THE INIT PHP FILE
require_once (__DIR__.'/../app/config/_env.php'); //LOAD ENVIRONMENT VARIABLES




//INSTANTIATE THE DATABASE CLASS
new \App\Classes\Database();




//SET CUSTOM ERROR HANDLER
set_error_handler([new \App\Classes\ErrorHandler(), 'handleErrors']);




//LOAD THE ROUTES FILE
require_once (PROOT. "app" .DS. "routing" .DS. "routes.php");





new \App\routing\RouteDispatcher($router);




?>