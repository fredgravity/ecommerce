<?php
/**
 * Created by PhpStorm.
 * User: Gravity
 * Date: 07/08/2018
 * Time: 9:11 AM
 */

namespace App\controllers\Admin;


use App\Classes\CSRFToken;
use App\Classes\Redirect;
use App\classes\Request;
use App\classes\Role;
use App\Classes\Session;
use App\Classes\UploadFile;
use App\classes\ValidateRequest;
use App\Controllers\BaseController;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use Carbon\Carbon;
use Illuminate\Database\Capsule\Manager as Capsule;


class ProductController extends BaseController
{

    public $tableName = 'products', $categories, $catLinks, $subcategory, $subcategoryLinks, $products, $productLinks, $search;
    private $_data, $_tmpFile;

    public function __construct()
    {

        //REDIRECT USER TO LOGIN PAGE IS USER IS NOT ADMIN
        if (!Role::middleware('admin')){
            Redirect::to('/login');
        }

        $this->categories = Category::all();
        $productObj = new Product;
        $total = $productObj->all()->count();

        //PRODUCT DB DATA AND PAGINATION
          list($this->products, $this->productLinks) = paginate(10, $total, $this->tableName, $productObj);
//        list($this->subcategory, $this->subcategoryLinks) = paginate(8, $subTotal, 'sub_categories', $subObj);

    }


    public function showCreateProductForm(){

        $categories = $this->categories;
        return view('admin/products/create', compact('categories'));

    }

    public function show(){
        $products = $this->products;
        $productLinks = $this->productLinks;
        $categories = $this->categories;
        view('admin/products/inventory', compact('products', 'productLinks', 'categories'));
    }

    public function showEditProductForm($id){
        $categories = $this->categories;
        //GET PRODUCT RELATIONSHIP WITH CATEGORY AND SUBCATEGORY
        $products = Product::where('id', $id)->with(['category', 'subCategory'])->first();
        return view('/admin/products/edit', compact('products', 'categories'));
    }


    public function store(){
        if(Request::exist('post')){
            $request = Request::get('post');
            $fileError = [];

            //CHECK TOKEN
            if(CSRFToken::checkToken($request->token, false)){

                //SET RULES
                $policyRules = [
                    'name' => ['required'=>true, 'string'=>true, 'minLength'=>3, 'unique'=>$this->tableName ],
                    'price' => ['required'=>true, 'minLength'=>2, 'number'=>true],
                    'quantity'=>['required'=>true],
                    'category'=>['required'=>true],
                    'subcategory'=>['required'=>true],
                    'description'=>['required'=>true, 'mixed'=>true, 'minLength'=>4, 'maxLength'=>200]
            ];

                //VALIDATE THE FORM DATA AGAINST THE RULES
                $validator = new ValidateRequest;
                $validator->abide($_POST, $policyRules);

                //VALIDATE FILE UPLOAD
                $file = Request::get('file');
                isset($file->productImage->name)? $filename = $file->productImage->name : $filename = '';


                if(empty($filename)){
                    $fileError['productImage'] = ['The product image is required'];
                }elseif (!UploadFile::isImage($filename)){
                    $fileError['productImage'] = ['Make sure the file is an Image'];
                }elseif ($file->productImage->tmp_name === ''){
                    $fileError['productImage'] = ['Please select the file again'];
                }elseif (UploadFile::fileSize($file->size)){
                    $fileError['productImage'] = ['Please select an image of your Certificate < 500kb'];
                }


                //CHECK IF TEMP LOCATION EXIST
                if($file->productImage->tmp_name === ''){
                    $fileError['productImage'] = ['Please select the file again'];
                }


                //CHECK IF VALIDATION HAS ERRORS
                if($validator->hasError() || count($fileError)){
                    $response = $validator->getErrorMessages();
                    count($fileError)? $errors = array_merge($response, $fileError) : $errors= $response;

                    if (count($errors)){
                        return view('admin/products/create', [
                            'categories' => $this->categories, 'errors'=>$errors
                        ]);
                    }

                }

                $tmpFile = $file->productImage->tmp_name;
                $optimideTo = "images" .DS. 'optimiseImages'. DS . "products". DS . user()->username;
                $folder = "images" .DS. "uploads" .DS. "products". DS . user()->username;

                //CREATE IMAGE PATH
                $imagePath = UploadFile::move($tmpFile, $folder, $optimideTo, $filename)->optimisedPath();


                //CREATE THE CATEGORY
                Product::create(
                    [
                        'user_id' => user()->id,
                        'user_role' => user()->role,
                        'name'  => ucwords($request->name),
                        'price'  => $request->price,
                        'quantity'  => $request->quantity,
                        'description' => $request->description,
                        'category_id' => $request->category,
                        'sub_category_id'=> $request->subcategory,
                        'image_path' => $imagePath
                    ]

                );

                //REFRESH FORM DATA
                Request::refresh();

                //RETURN THE CATEGORY AND SUBCATEGORY VIEWS

                $success = 'New Product Added';

                view('admin/products/create', [
                    'categories' => $this->categories, 'catLinks' => $this->catLinks, 'success' => $success

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

    public function edit(){
        if(Request::exist('post')){
            $request = Request::get('post');
            $fileError = [];

            //CHECK TOKEN
            if(CSRFToken::checkToken($request->token, false)){
                //SET RULES
                $policyRules = [
                    'name' => ['required'=>true, 'string'=>true, 'minLength'=>3, 'mixed'=>true],
                    'price' => ['required'=>true, 'minLength'=>2, 'number'=>true],
                    'quantity'=>['required'=>true],
                    'category'=>['required'=>true],
                    'subcategory'=>['required'=>true],
                    'description'=>['required'=>true, 'mixed'=>true, 'minLength'=>4, 'maxLength'=>200]
                ];

                //VALIDATE THE FORM DATA AGAINST THE RULES
                $validator = new ValidateRequest;
                $validator->abide($_POST, $policyRules);

                //VALIDATE FILE UPLOAD
                $file = Request::get('file');
                isset($file->productImage->name)? $filename = $file->productImage->name : $filename = '';

                if (isset($file->productImage->name) && !UploadFile::isImage($filename)){
                    $fileError['productImage'] = ['The image is invalid. Please try again later'];
                }

//pnd($fileError);
                //CHECK IF VALIDATION HAS ERRORS
                if($validator->hasError()){
                    $response = $validator->getErrorMessages();
                    count($fileError)? $errors = array_merge($response, $fileError) : $errors= $response;


                    $categories = $this->categories;
                    $products = Product::where('id', $request->product_id)->with(['category', 'subCategory'])->first();
                    return view('/admin/products/edit', compact('products', 'categories', 'errors'));
                }

                //FIND PRODUCT ID OR THROW AN EXCEPTION
                $product = Product::findOrFail($request->product_id);
//                if(!$product){
//                    throw new \Exception('Invalid Product ID');
//                }

                //UPDATE THE PRODUCT
                $product->name = $request->name;
                $product->price = $request->price;
                $product->quantity = $request->quantity;
                $product->description = $request->description;
                $product->category_id = $request->category;
                $product->sub_category_id = $request->subcategory;


                //CHECK IF FILENAME HAS BEEN PROVIDED
                if ($filename){
                    $oldImagePath = PROOT.'public'.DS.$product->image_path;
                    $tempFile = $file->productImage->tmp_name;
                    $imagePath = UploadFile::move($tempFile, "images" .DS. "uploads" .DS. "products", $filename)->path();
                    unlink($oldImagePath);
                    $product->image_path = $imagePath;
                }
                $product->save();
                Session::flash('success', 'Product updated successfully');
                Redirect::to('/admin/products');


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
               Product::destroy($id);


               Session::flash('success', 'Product Deleted Successfully');
               Redirect::to('/admin/products');

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


    public function getSubcategory($id){

        $subCategories = SubCategory::where('category_id', $id)->get();
        echo json_encode($subCategories); exit();
    }

    public function searchProduct(){
        if (Request::exist('post')){
            $request = Request::get('post');
//pnd($request);
            if (CSRFToken::checkToken($request->token, false)){
                if ($request->search_field){
                    $products = Product::where([['name', 'LIKE', "%$request->search_field%"], ['category_id', $request->category], ['sub_category_id', $request->subCategory]])
                        ->with('category', 'subCategory')->orderBy('id', 'desc')->get();
                }else{
                    $products = Product::where([ ['category_id', $request->category], ['sub_category_id', $request->subCategory]])
                        ->with('category', 'subCategory')->orderBy('id', 'desc')->get();
                }
//             $products = Product::where([['name', 'LIKE', "%$request->search_field%"], ['category_id', $request->category], ['sub_category_id', $request->subCategory]])
//             ->with('category', 'subCategory')->orderBy('id', 'desc')->get();

//                pnd($products);

                $total = $products->count();
                $categories = $this->categories;

                return view('/admin/products/SearchInventory', compact('products', 'total', 'categories'));

            }else{
                $env = getenv('APP_ENV');
                if($env !== 'production'){
                    throw new \Exception('Token Mismatch');
                }
                $this->show();


            }

        }

        return null;
    }







}
?>