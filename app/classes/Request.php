<?php
/**
 * Created by PhpStorm.
 * User: Gravity
 * Date: 06/08/2018
 * Time: 2:01 PM
 */

namespace App\classes;


class Request
{

    //RETURN ALL REQUEST THAT WE ARE INTERESTED IN
    public static function all($isArray = false){
        $result = [];
        //STORE GET REQUEST IN RESULT ARRAY IF GET COUNT IS > 0
        if(count($_GET) > 0) $result['get'] = $_GET;

        //STORE POST REQUEST IN RESULT ARRAY IF POST COUNT IS > 0
        if(count($_POST) > 0) $result['post'] = $_POST;

        // STORE FILE REQUEST  IN RESULT ARRAY
        $result['file'] = $_FILES;

        $jsonData = json_encode($result);
        return json_decode($jsonData, $isArray);//RETURN AN ASSOC ARRAY OR JSON OBJECT

    }

    //GET SPECIFIC REQUEST TYPE
    public static function get($key){
        $obj = new static;
        $data = $obj->all();


        return $data->$key; // RETURNS THE VALUES OF A POST OR GET KEYS
    }

    //CHECK REQUEST AVAILABILITY
    public static function exist($key){
        return (array_key_exists($key, self::all(true)))? true : false;
    }

    //GET REQUEST DATA
    public static function oldData($key, $value){
        $obj = new static;
        $data = $obj->all();


        return isset($data->$key->$value)? $data->$key->$value : '';

    }

    //REFRESH REQUEST
    public static function refresh(){
        $_GET = [];
        $_POST = [];
        $_FILES = [];
    }

    //INPUT REQUEST
    public static function getInput($data){
        if(isset($_POST[$data])){
            return $_POST[$data];
        }elseif (isset($_GET[$data])){
            return $_GET[$data];
        }else{
         return '';
        }
    }

}
?>