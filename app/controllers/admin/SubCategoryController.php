<?php
/**
 * Created by PhpStorm.
 * User: Gravity
 * Date: 07/08/2018
 * Time: 9:11 AM
 */

namespace App\controllers\admin;


use App\Classes\CSRFToken;
use App\Classes\Redirect;
use App\classes\Request;
use App\classes\Role;
use App\Classes\Session;
use App\classes\ValidateRequest;
use App\Controllers\BaseController;
use App\Models\Category;
use App\Models\SubCategory;
use Carbon\Carbon;

class SubCategoryController extends BaseController
{


    public function __construct()
    {
        //REDIRECT USER TO LOGIN PAGE IS USER IS NOT ADMIN
        if (!Role::middleware('admin')){
            Redirect::to('/login');
        }
    }

    public function store(){
        if(Request::exist('post')){
            $request = Request::get('post');
            $extraError = [];

            //CHECK TOKEN
            if(CSRFToken::checkToken($request->token, false)){
                //SET RULES
                $policyRules = [
                    'name' => ['required'=>true, 'string'=>true, 'minLength'=>3],
                    'category_id' => ['required'=>true]

                ];

                //VALIDATE THE FORM DATA AGAINST THE RULES
                $validator = new ValidateRequest;
                $validator->abide($_POST, $policyRules);

                //CHECK IF SUBCATEGORY NAME AND ID ALREADY EXISTS IN THE SUBCATEGORY TABLE IN THE DB(EXISTING SUBCATEGORY)
                $duplicateSubCategory = SubCategory::where('name', $request->name)->where('category_id', $request->category_id)->exists();
                if($duplicateSubCategory){
                    $extraError['error'] = array('Subcategory already exists');
                }


                //CHECK IF THERE IS NO CATEGORY ID ALREADY EXISTS IN TH CATEGORY TABLE CREATE ERROR(CATEGORY DOESNT EXIST)
                $categoryExists = Category::where('id', $request->category_id)->exists();
                if(!$categoryExists){
                    $extraError['error'] = array('Invalid product category');
                }


                //CHECK IF VALIDATION HAS ERRORS
                if($validator->hasError() || $duplicateSubCategory || !$categoryExists){
                    $errors = $validator->getErrorMessages();
                    count($extraError)? $response = array_merge($errors, $extraError) : $response = $errors;

                    header('HTTP/1.1 422 Unprocessable Entity', true, 422);
                    echo json_encode($response); exit();

                }


                //CREATE THE CATEGORY
                SubCategory::create(
                    [
                        'name'  => $request->name,
                        'slug'  => slug($request->name),
                        'category_id'   => $request->category_id
                    ]
                );

                //RETURN WITH AJAX SUCCESS MESSAGE

                echo json_encode(['success' => 'Subcategory created Successfully']); exit();

            }else{
                $env = getenv('APP_ENV');
                if($env === 'local'){
                    throw new \Exception('Token Mismatch');
                }
                die('Token Mismatch');


            }

        }

        return null;
    }

    public function edit($id){
        if(Request::exist('post')){
            $request = Request::get('post');
            $extraError = [];

            //CHECK TOKEN
            if(CSRFToken::checkToken($request->token, false)){
                //SET RULES
                $policyRules = [
                    'name' => ['required'=>true, 'string'=>true, 'minLength'=>3],
                    'category_id' => ['required'=>true]

                ];

                //VALIDATE THE FORM DATA AGAINST THE RULES
                $validator = new ValidateRequest;
                $validator->abide($_POST, $policyRules);

                //CHECK IF SUBCATEGORY NAME AND ID ALREADY EXISTS IN THE SUBCATEGORY TABLE IN THE DB(EXISTING SUBCATEGORY)
                $duplicateSubCategory = SubCategory::where('name', $request->name)->where('category_id', $request->category_id)->exists();
                if($duplicateSubCategory){
                    $extraError['error'] = array('You have not made any changes');
                }


                //CHECK IF THERE IS NO CATEGORY ID ALREADY EXISTS IN TH CATEGORY TABLE CREATE ERROR(CATEGORY DOESNT EXIST)
                $categoryExists = Category::where('id', $request->category_id)->exists();
                if(!$categoryExists){
                    $extraError['error'] = array('Invalid product category');
                }


                //CHECK IF VALIDATION HAS ERRORS
                if($validator->hasError() || $duplicateSubCategory || !$categoryExists ){
                    $errors = $validator->getErrorMessages();
                    count($extraError)? $response = array_merge($errors, $extraError) : $response = $errors;

                    header('HTTP/1.1 422 Unprocessable Entity', true, 422);
                    echo json_encode($response); exit();

                }


                SubCategory::where('id', $id)->update(['name' => $request->name, 'category_id'=>$request->category_id]);

                //RETURN WITH AJAX SUCCESS MESSAGE

                echo json_encode(['success' => 'Subcategory Updated Successfully']); exit();

            }else{
                $env = getenv('APP_ENV');
                if($env === 'local'){
                    throw new \Exception('Token Mismatch');
                }
                die('Token Mismatch');


            }

        }

        return null;
    }

    public function delete($id){
        if(Request::exist('post')){
            $request = Request::get('post');

            //CHECK TOKEN
            if(CSRFToken::checkToken($request->token)){

               SubCategory::destroy($id);
               Session::flash('success', 'Sub Category Deleted Successfully');
               Redirect::to('/admin/product/categories');

            }else{
                $env = getenv('APP_ENV');
                if($env === 'local'){
                    throw new \Exception('Token Mismatch');
                }
                die('Token Mismatch');


            }

        }

        return null;
    }

}
?>