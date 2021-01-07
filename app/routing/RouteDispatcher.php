<?php
/**
 * Created by PhpStorm.
 * User: Gravity
 * Date: 21/07/2018
 * Time: 12:53 PM
 */

namespace App\routing;

use AltoRouter;
use function Clue\StreamFilter\fun;

class RouteDispatcher
{

    protected $_match, $_controller, $_method;

    public function __construct(AltoRouter $router)
    {

        $this->_match = $router->match();
//pnd($this->_match);

        if($this->_match){
            list($controller, $method) = explode('@', $this->_match['target']);
            $this->_controller = $controller;
            $this->_method = $method;

            $myClass = new $controller;
            spl_autoload_register([$myClass, $method]);

            call_user_func_array([$myClass, $this->_method], [$this->_match['params']]);

//            spl_autoload_register(function (){
//                $ary = explode('\\', $this->_controller);
//                if (count($ary) === 3){
//                    list($one, $two, $class) = explode('\\', $this->_controller);
//                    $className = strtolower($one).'\\'.strtolower($two).'\\'.$class.'.php';
//
//                }elseif (count($ary) === 4){
//                    list($one, $two, $three, $class) = explode('\\', $this->_controller);
//                    $className = strtolower($one).'\\'.strtolower($two).'\\'. strtolower($three).'\\'.$class.'.php';
//
//                }
//
//                $file = PROOT.$className;
//
//                if(file_exists($file)){
//                    require_once $file;
//                    $controller = new $this->_controller;
////dnd(is_callable([$controller, $this->_method]));
//                    if(is_callable([$controller, $this->_method])){
//                        call_user_func_array([$controller, $this->_method], [$this->_match['params']]);
//                    }else{
//                        echo "This method $this->_method is not defined in the $this->_controller class";
//                    }
//                }else{
//                    echo 'Cannot find file'; exit();
//                }
//
//
//
//            });

//            //CHECK IF CLASS AND METHOD IS CALLABLE
//            if(is_callable([new $this->_controller, $this->_method])){
//                call_user_func_array([new $this->_controller, $this->_method], [$this->_match['params']]);
//            }else{
//                echo "This method $this->_method is not defined in the $this->_controller class";
//            }

        }else{
            header($_SERVER['SERVER_PROTOCOL'].'404 Not Found');
            view('errors/404');
        }


    }

}