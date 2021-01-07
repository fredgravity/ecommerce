<?php
/**
 * Created by PhpStorm.
 * User: Gravity
 * Date: 20/10/2018
 * Time: 6:09 PM
 */

namespace App\classes;


class ErrorOutput
{

    public function __construct($view)
    {


    }


    public function DisplayError($error){
        $env = getenv('APP_ENV');
        if ($env !== 'production'){

            switch ($error){
                case 'token':
                    throw new \Exception('Token Mismatch');
                    break;

                default:
                    throw new \Exception(':( OOOPS!, Something went wrong please try again later.');
            }

        }else{

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