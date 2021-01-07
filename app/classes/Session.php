<?php
/**
 * Created by PhpStorm.
 * User: Gravity
 * Date: 01/08/2018
 * Time: 8:28 AM
 */

namespace App\Classes;


class Session
{

    //CREATE A SESSION
    public static function set($name, $value){
        if($name != '' && !empty($name) && $value != '' && !empty($value)){
            return $_SESSION[$name] = $value;
        }
        throw new \Exception('Name and Value required');
    }


    //GET SESSION VALUE
    public static function get($name){
        return $_SESSION[$name];
    }


    //CHECK IF SESSION EXIST
    public static function exist($name){
        if($name != '' && !empty($name)){
            return (isset($_SESSION[$name])) ? true : false ;
        }
        throw new \Exception('Name is required');
    }


    //REMOVE SESSION
    public static function delete($name){
        if(self::exist($name)){
            unset($_SESSION[$name]);

        }
    }


    //SESSION FLASH
    public static function flash($name, $string = ''){
        if(self::exist($name)){
            $flash = self::get($name);
            self::delete($name);
            return $flash;
        }
        self::set($name, $string);
    }


    //USER AGENT
    public static function uagentNoVersion(){
        $uagent = $_SERVER['HTTP_USER_AGENT'];
        $regx = '/\/[0-9A-Z-a-z.]+/';
        $newUagent = preg_replace($regx, '', $uagent);
        return $newUagent;
    }


}



?>