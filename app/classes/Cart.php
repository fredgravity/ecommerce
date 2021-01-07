<?php
/**
 * Created by PhpStorm.
 * User: Gravity
 * Date: 13/09/2018
 * Time: 11:48 AM
 */

namespace App\classes;


class Cart
{

    protected static $_isItemInCart = false;

    public static function add($request){
        //TRY TO GET CART ITEMS
        try{


            //CHECK IF SESSION EXIST FOR CART OR THE COUNT OF CART ITEMS OTHERWISE ADD NEW CART SESSION
            if(!Session::exist('user_cart') || count(Session::get('user_cart')) < 1){
                Session::set('user_cart', [
                    //MULTI ARRAY OF SESSION VALUE
                    0 => [
                        //CART KEY          CART VALUE
                        'product_id' => $request->product_id,
                        'quantity'   => 1
                    ]
                ]);
            }else{
                $index = 0;
                foreach ($_SESSION['user_cart'] as $cartItem) {
                    $index++; //INCREASE THE INDEX VALUE
//pnd($cartItem);
                    //CHECK IF CART KEY AND CART VALUE ARE WHAT IS BEING LOOPED THROUGH
                    foreach ($cartItem as $key => $value) {
                        if($key == 'product_id' && $value == $request->product_id){
                            array_splice($_SESSION['user_cart'], $index - 1, 1, [
                                [
                                    'product_id' => $request->product_id,
                                    'quantity'   => $cartItem['quantity'] + 1
                                ]
                            ]);
                            self::$_isItemInCart = true;
                        }
                    }
                }

                //CHECK IF ITEM IS NOT ALREADY ADDED TO THE CART
                if(!self::$_isItemInCart){
                    array_push($_SESSION['user_cart'], [
                        'product_id'    => $request->product_id,
                        'quantity'      => 1
                    ]);
                }
            }


        }catch (\Exception $e){
            $env = getenv('APP_ENV');
            if($env === 'local'){
                echo 'Message: '. $e->getMessage();
            }else{
                echo 'Error in Adding to the cart';
            }
        }

    }

    public static function removeItem($index){
        if (count(Session::get('user_cart')) <= 1){
            //CLEAR SESSION
            self::clear();

        }else{
            unset($_SESSION['user_cart'][$index]);
            sort($_SESSION['user_cart']);
        }

    }


    public static function clear(){
        Session::delete('user_cart');
    }



}




?>