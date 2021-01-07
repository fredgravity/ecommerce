<?php
/**
 * Created by PhpStorm.
 * User: Gravity
 * Date: 26/07/2018
 * Time: 2:03 PM
 */

namespace App\Classes;


class ErrorHandler
{

    public function outputFriendlyError(){
        ob_end_clean(); //NO OTHER HTML GETS DISPLAYED
        view('/errors/generic');
        exit();
    }



    public static function emailAdmin($data){
        $mail = new MailingWithGun();
        $mail->send($data);
        return new static;
    }



    public function handleErrors($errorNumber, $errorMessage, $errorFile, $errorLine){
        $error = "[$errorNumber] An error occurred in file $errorFile on line $errorLine: $errorMessage";

        $env = getenv('APP_ENV');
        if($env !== 'production'){
            //HANDLE ERRORS WITH WHOOPS IN LOCAL ENVIRONMENTS
            $whoops = new \Whoops\Run;
            $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
            $whoops->register();
        }else{
            //SEND THE ERROR TO ADMIN AND DISPLAY FRIENDLY ERRORS
            $data = [
                'to'    => getenv('ADMIN_EMAIL'),
                'subject'=> 'System Error',
                'view'  => 'errors',
                'name'  => 'Admin',
                'body'  => $error
            ];
            ErrorHandler::emailAdmin($data)->outputFriendlyError();
        }
    }








}



?>