<?php
/**
 * Created by PhpStorm.
 * User: Gravity
 * Date: 03/08/2018
 * Time: 2:31 PM
 */

namespace App\Classes;


class Redirect
{

    public static function to($location=null){
        if($location){
            //CHECK IF HEADERS ARE SENT OR NOT
            if(!headers_sent()){
                //DO THIS IF HEADERS ARE NOT SENT
                if(is_numeric($location)){
                    //IF NUMERIC

                    switch ($location){

                        case 404:
                            header('Location: '.PROOT.'resources/views/errors/404');
                            break;
                        case 505:
                            header('Location: '.PROOT.'resources/views/errors/404');
                            break;

                    }
                }else{
                    //IF NOT NUMERIC
                    header("Location: $location");
                    exit();
                }

            }else{
                //IF HEADERS HAS BEEN SENT ALREADY THEN SEND AGAIN WITH JS
                echo '
                    <script type="text/javascript">
                        window.location.href="'.PROOT.$location.'";
                    </script>
                    <noscript>
                        <meta http-equiv="refresh" content="@;url='.$location.'" />
                    </noscript>
              ';
                exit();

            }
        }
    }


    public static function back(){
        //REDIRECT BACK TO THE SAME PAGE
        $uri = $_SERVER['REQUEST_URI'];
        header("Location: $uri");
    }



}
?>