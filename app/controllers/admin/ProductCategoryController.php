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
use App\Classes\Session;
use App\classes\ValidateRequest;
use App\Controllers\BaseController;
use App\Models\Category;
use App\Models\SubCategory;
use Carbon\Carbon;
use Illuminate\Database\Capsule\Manager as Capsule;
use App\classes\Role;

class ProductCategoryController extends BaseController
{

    public $tableName = 'categories', $categories, $catLinks, $subcategory, $subcategoryLinks;
    private $_data;

    public function __construct()
    {

        //REDIRECT USER TO LOGIN PAGE IS USER IS NOT ADMIN
        if (!Role::middleware('admin')){
            Redirect::to('/login');
        }


        $total = Category::all()->count();
        $subTotal = SubCategory::all()->count();
        $obj = new Category;
        $subObj = new SubCategory;
        $this->_data = $obj->transform(Capsule::select("SELECT * FROM $this->tableName WHERE deleted_at is null ORDER BY created_at DESC "));

        list($this->categories, $this->catLinks) = paginate(10, $total, $this->tableName, $obj);
        list($this->subcategory, $this->subcategoryLinks) = paginate(10, $subTotal, 'sub_categories', $subObj);

    }


    public function show(){

        if( count($this->subcategory) > count($this->categories) ){
           return view('admin/products/categories', [
                'categories' => $this->_data, 'catLinks'=>false,
                'subcategories' => $this->subcategory, 'subcategoryLinks' => $this->subcategoryLinks

            ]);
        }else{
            return view('admin/products/categories', [
                'categories' => $this->categories, 'catLinks' => $this->catLinks,
                'subcategories' => $this->subcategory, 'subcategoryLinks' => $this->subcategoryLinks

            ]);
        }


    }


    public function store(){
        if(Request::exist('post')){
            $request = Request::get('post');

            //CHECK TOKEN
            if(CSRFToken::checkToken($request->token)){
                //SET RULES
                $policyRules = [ 'name' => ['required'=>true, 'string'=>true, 'minLength'=>3, 'unique'=>'categories'] ];

                //VALIDATE THE FORM DATA AGAINST THE RULES
                $validator = new ValidateRequest;
                $validator->abide($_POST, $policyRules);

                //CHECK IF VALIDATION HAS ERRORS
                if($validator->hasError()){
                    $errors = $validator->getErrorMessages();
                    if( count($this->subcategory) > count($this->categories) ){
                        return view('admin/products/categories', [
                            'categories' => $this->_data, 'catLinks'=>false, 'errors'=>$errors,
                            'subcategories' => $this->subcategory, 'subcategoryLinks' => $this->subcategoryLinks

                        ]);
                    }else{
                        return view('admin/products/categories', [
                            'categories' => $this->categories, 'catLinks' => $this->catLinks, 'errors'=>$errors,
                            'subcategories' => $this->subcategory, 'subcategoryLinks' => $this->subcategoryLinks

                        ]);
                    }

                }


                //CREATE THE CATEGORY
                Category::create(
                    [
                        'name'  => $request->name,
                        'slug'  => slug($request->name)
                    ]
                );

                //RETURN THE CATEGORY AND SUBCATEGORY VIEWS

                $total = Category::all()->count();
                $subTotal = SubCategory::all()->count();

                list($this->categories, $this->catLinks) = paginate(3, $total, $this->tableName, new Category);
                list($this->subcategory, $this->subcategoryLinks) = paginate(3, $subTotal, 'sub_categories', new SubCategory);

                $success = 'New Category Added';

                view('admin/products/categories', [
                    'categories' => $this->categories, 'catLinks' => $this->catLinks, 'success' => $success,
                    'subcategories' => $this->subcategory, 'subcategoryLinks' => $this->subcategoryLinks
                ]);

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

            //CHECK TOKEN
            if(CSRFToken::checkToken($request->token, false)){
                //SET RULES
                $policyRules = [ 'name' => ['required'=>true, 'string'=>true, 'minLength'=>3, 'unique'=>'categories'] ];

                //VALIDATE THE FORM DATA AGAINST THE RULES
                $validator = new ValidateRequest;
                $validator->abide($_POST, $policyRules);

                //CHECK IF VALIDATION HAS ERRORS
                if($validator->hasError()){
                    $errors = $validator->getErrorMessages();
                    header('HTTP/1.1 422 Unprocessable Entity', true, 422);
                    echo json_encode($errors); exit();
                }

                Category::where('id', $id)->update(['name' => $request->name]);
//                echo json_encode(['test'=> $request->name]);
                echo json_encode(['success' => 'Category Updated Successfully']); exit();

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
            if(CSRFToken::checkToken($request->token,false)){
               //SOFT DELETE CATEGORY
               Category::destroy($id);

               //DELETE ALL SUBCATEGORY UNDER THAT CATEGORY
                $subcategories = SubCategory::where('category_id', $id)->get();
                if(count($subcategories)){
                    foreach ($subcategories as $subcategory) {
                        $subcategory->delete();
                    }
                }

               Session::flash('success', 'Category Deleted Successfully');
               Redirect::to('/admin/product/categories');

            }else{
                $env = getenv('APP_ENV');
                if($env !== 'production'){
                    throw new \Exception('Token Mismatch');
                }
                die('Token Mismatch');


            }

        }

        return null;
    }

}
?>