<?php
/**
 * Created by PhpStorm.
 * User: Gravity
 * Date: 10/10/2018
 * Time: 1:30 PM
 */

namespace App\classes;


use App\Models\User;

class Role
{

    public static function middleware($role){
        //IF USER ROLE IS NOT ANY OF THE BELOW DISPLAY THE MESSAGE
        $message = '';

        switch ($role){
            case 'admin':
                $message = 'You are not authorised to view Admin Panel';
                break;

            case 'user':
                $message = 'You are not authorised to view User Panel';
                break;

            case 'vendor':
                $message = 'You are not authorised to view Vendor Panel';
                break;
        }

        //CHECK IF USER IS AUTHENTICATED
        if(isAuthenticated()){
            if (user()->role != $role){
                Session::flash('error', $message);
                return false;
            }
        }else{
            Session::flash('error', $message);
            return false;
        }

        return true;

    }


}







?>