<?php
/**
 * Created by PhpStorm.
 * User: gravity
 * Date: 2/5/2019
 * Time: 9:01 AM
 */

namespace App\classes;


class Cookie
{

    //EXIST
    public static function exist($name){
        return isset($_COOKIE[$name]);
    }

    //GET
    public static function getCookie($name){
        return $_COOKIE[$name];
    }

    //SET
    public static function setCookie($name, $value, $expiry){
        if (setcookie($name, $value, time() + $expiry, '/')){
            return true;

        }
        return false;
    }

    //DELETE
    public static function deleteCookie($name){
        return self::setCookie($name, '', 1);
    }


}















?>