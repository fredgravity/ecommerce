<?php
/**
 * Created by PhpStorm.
 * User: Gravity
 * Date: 08/08/2018
 * Time: 1:50 PM
 */

namespace App\classes;

use Illuminate\Database\Capsule\Manager as Capsule;

class ValidateRequest
{

    private static $_error = [];
    private static $_errorMessages = [
        'string'    => 'The :attribute field should contain only letters',
        'number'    => 'The :attribute field should contain only numbers e.g 20.0, 20',
        'required'  => 'The :attribute field is required',
        'minLength' => 'The :attribute field must be a minimum of :policy characters',
        'maxLength' => 'The :attribute field must be a maximum of :policy characters',
        'mixed'     => 'The :attribute field can contain only letters, numbers, dashes and spaces',
        'email'     => 'The Email provided is not valid',
        'unique'    => 'The :attribute already exist, please try another one'
    ];


    public function abide(array $formData, array $policies){

        foreach ($formData as $field => $value) {
            //CHECK IF FORM INPUT NAMES ARE IN THE KEYS OF POLICY MULTI ARRAY
            if(in_array($field, array_keys($policies))){

                // PROCESS VALIDATION
                self::doValidation( ['column' => $field, 'value' => $value, 'policies' => $policies[$field]] );
            }
        }

    }


    private static function doValidation(array $data){
        $fieldName   = $data['column'];
        $value       = $data['value'];
        $policies    = $data['policies'];

        foreach ($policies as $rule => $policy) {
            //CALL THIS CLASS AND CHECK IF THE SPECIFIED METHOD EXIST & PASS IN THE PARAMS
            $valid = call_user_func_array([self::class, $rule],[$fieldName, $value, $policy]);

            //SET ERROR IF METHOD DOESNT EXIST IN THE CLASS
            if(!$valid){
                self::setError(
                    str_replace([':attribute', ':policy', '_'], [$fieldName, $policy, ' '], self::$_errorMessages[$rule])
                    , $fieldName);
            }
        }
    }


    protected static function unique($column, $value, $policy){

      if($value != null && !empty(trim($value))){
          // RETURN FALSE IF VALUE ALREADY EXIST IN THE POLICY TABLE DB(COLUMN)
          return !Capsule::table($policy)->where($column, '=', $value)->exists();

      }
          return true;

  }

    protected static function required($column, $value, $policy){

      return $value !== null && !empty(trim($value));

  }

    protected static function minLength($column, $value, $policy){

      if($value != null && !empty($value)){

        return strlen($value) >= $policy;

      }
      return true;
  }

    protected static function maxLength($column, $value, $policy){

        if($value != null && !empty($value)){

            return strlen($value) <= $policy;

        }
        return true;
    }

    protected static function email($column, $value, $policy){
        if($value != null && !empty($value)){

            return filter_var($value, FILTER_VALIDATE_EMAIL);

        }
        return true;
    }

    protected static function mixed($column, $value, $policy){
        if($value != null && !empty($value)){

            if(!preg_match('/^[A-Za-z0-9 .,_~\-!@#\&%\^\'\*\(\)]+$/', $value)){
                return false;
            }

        }
        return true;
    }

    protected static function string($column, $value, $policy){
        if($value != null && !empty($value)){

            if(!preg_match('/^[A-Za-z ]+$/', $value)){
                return false;
            }

        }
        return true;
    }

    protected static function number($column, $value, $policy){
        if($value != null && !empty($value)){

            if(!preg_match('/^[0-9.]+$/', trim($value))){
                return false;
            }

        }
        return true;
    }


    private static function setError($error, $key){
        if ($key){
            self::$_error[$key][] = $error;
        }else{
            self::$_error[] = $error;
        }
    }

    public function hasError(){
        //CHECK IF ERROR ARRAY HAS ANY VALUE
        return count(self::$_error) > 0 ? true : false;
    }


    public function getErrorMessages(){
        return self::$_error;
    }

}
?>