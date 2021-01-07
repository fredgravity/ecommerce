<?php
/**
 * Created by PhpStorm.
 * User: Gravity
 * Date: 03/08/2018
 * Time: 1:52 PM
 */

namespace App\Classes;


class CSRFToken
{

    //GENERATE TOKEN
    public static function generate(){
        if(!Session::exist('token')){
            $tokenValue = base64_encode(openssl_random_pseudo_bytes(32));
            Session::set('token', $tokenValue);
        }
        return Session::get('token');
    }


    //CHECK TOKEN GENERATED
    public static function checkToken($tokenName, $regenerate = true){
        if(Session::exist('token') && Session::get('token') === $tokenName){
            if($regenerate){
                Session::delete('token');
            }

            return true;
        }
        return false;
    }


}



?>