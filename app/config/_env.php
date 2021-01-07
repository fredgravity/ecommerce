<?php

define('BASE_PATH', realpath(__DIR__.'/../../')); //REAL ROOT PATH OF THE PROJECT




define('DS', DIRECTORY_SEPARATOR);//DIRECTORY SEPARATOR




define('PROOT', dirname(__FILE__).DS . '..' . DS . '..'. DS);//PROJECT ROOT OF THE PROJECT




require_once PROOT ."app" .DS. "functions" .DS."helper.php";//LOAD IN THE HELPER FUNCTIONS




require_once ( PROOT ."vendor" .DS. "autoload.php");//LOAD IN THE COMPOSER AUTOLOADER




$dotEnv = new \Dotenv\Dotenv(BASE_PATH);




$dotEnv->load();



?>