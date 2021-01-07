<?php
/**
 * Created by PhpStorm.
 * User: Gravity
 * Date: 20/07/2018
 * Time: 4:35 PM
 */

namespace App\Controllers;



use App\classes\Cookie;
use App\Classes\CSRFToken;
use App\Classes\Mail;
use App\classes\MailingWithGun;
use App\Classes\Redirect;
use App\classes\Request;
use App\Classes\Session;
use App\classes\ValidateRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use Mailgun\Mailgun;

class IndexController extends BaseController
{

    public $categories, $num = [];

    public function __construct()
    {

        $this->cookieLogin();

        $this->categories = Category::all();
        $ids = Category::pluck('id', 'name');

        foreach ($ids as $id) {
            $this->num[] = Product::where('category_id', $id)->get()->count();
        }

    }


    public function cookieLogin(){
        //CHECK IF EXIST WITH NO SESSION AND LOG USER IN
//        dnd(Cookie::exist(getenv('COOKIE_NAME')));
        if ((!Session::exist('SESSION_USER_ID') && !Session::exist('SESSION_USER_NAME')) && Cookie::exist(getenv('COOKIE_NAME')) ){
            AuthController::loginWithCookie();

        }

    }


    public function show(){
        //GENERATE TOKEN FOR HOME PAGE
        $token = CSRFToken::generate();
        $categories = $this->categories;
        return view('home', compact('token', 'categories'));
//        view('home', ['token' => $token]);
    }


    public function contactUs(){

        $categories = $this->categories;
        return view('/contactus', compact('categories'));
    }

    public function contactUsSend(){

        if (Request::exist('post')){
            $request = Request::get('post');

            if (CSRFToken::checkToken($request->token, false)){
//                pnd($request);

                //CREATE VALIDATION RULES
                $rules = [
                    'phone' => ['required'=>false, 'number' => true, 'minLength' => 5, 'maxLength' => 15 ],
                    'email' => ['required' => true, 'email' => true, 'mixed' => true],
                    'fullname' => ['required' => true, 'minLength' => 6, 'maxLength' => 50],
                    'message' => ['required' => true, 'minLength' => 5, 'maxLength' => 200, 'mixed' => true]
                ];

                $validate = new ValidateRequest;
                $validate->abide($_POST, $rules);

                if ($validate->hasError()){
                    $errors = $validate->getErrorMessages();

                    $categories = $this->categories;
                    return view('/contactus', compact('errors', 'categories'));

                }

                //SEND EMAIL TO ARTISAO ADMIN
                $data = [
                    'to'    => getenv('ADMIN_EMAIL'),
                    'subject'=> 'Contact Us',
                    'view'  => 'contactus',
                    'name'  => 'Admin',
                    'body'  => [
                        'name' => $request->fullname,
                        'email' => $request->email,
                        'phone' => $request->phone,
                        'message' => $request->message
                    ]
                ];

                IndexController::emailAdmin($data);
                $success = 'Email has been sent to admin. Please expect our feedback soon';
                $categories = $this->categories;
                Request::refresh();
                return view('/contactus', compact('success', 'categories'));

            }


        }
        return false;
    }

    public static function emailAdmin($data){
        $mail = new MailingWithGun;
        $mail->send($data);
        return new static ;
    }

    public function featuredProducts(){
        $products = Product::where('featured', 1)->inRandomOrder()->limit(4)->get();
        echo json_encode(['featured' => $products]);
    }

    public function getProducts(){
        $products = Product::where('featured', 0)->skip(0)->take(2)->orderBy('id', 'desc')->get();
        echo json_encode(['products' => $products, 'count' => count($products)]);
    }

    public function loadMoreProducts(){
        $request = Request::get('post');

        //CHECK TOKEN
        if(CSRFToken::checkToken($request->token, false)){

            //GET COUNT FROM HOME PAGE
            $count = $request->count;
            $itemPerPage = $count + $request->next;

            $products = Product::where('featured', 0)->skip(0)->take($itemPerPage)->orderBy('id', 'desc')->get();
            echo json_encode(['products' => $products, 'count' => count($products)]);
        }
    }


    public function allSubcategoryItemsShow($id){
        $token = CSRFToken::generate();

        $categories = Category::all();
        $searchWord = SubCategory::where('id', $id)->first()->name;
        $totalItems = $this->num;
        $subItems = Product::where('sub_category_id', $id)->get();
        $advance = '';

        return view('/subItems', compact('subItems', 'subItemName','categories','searchWord', 'advance', 'token', 'totalItems'));
//        pnd($subItems);
    }

    public function getSubItems(){

        if(Request::exist('post')){
            $request = Request::get('post');
            if( is_numeric($request->id)){

                $subItems = Product::where('sub_category_id', $request->id )->take(8)->get();
                if (count($subItems)){
                    echo json_encode(['subItems' => $subItems, 'count' => count($subItems)]);exit();
                }else{
                    echo json_encode(['subItems' => false]);exit();
                }

            }

        }

    }

    public function loadMoreSubitems(){
        $request = Request::get('post');

        //CHECK TOKEN
        if(CSRFToken::checkToken($request->token, false)){

            //GET COUNT FROM HOME PAGE
            $count = $request->count;
            $itemPerPage = $count + $request->next;


            $subItems = Product::where('sub_category_id', $request->id)->take($itemPerPage)->get();
            echo json_encode(['subItems' => $subItems, 'count' => count($subItems)]);
        }
    }


    public function allCategoryItemsShow($id){
        $token = CSRFToken::generate();

        $categories = Category::all();
        $categoryItems = Category::where('id', $id)->get();
        $searchWord = $categoryItems->first()->name;
        $totalItems = $this->num;
//pnd($categoryItemName);
        $advance = '';
        return view('/categoryItems', compact('categoryItems', 'categoryItemName','categories','searchWord', 'advance', 'token', 'totalItems'));
    }



    public function getCategoryItems(){

        if(Request::exist('post')){
            $request = Request::get('post');
            if( is_numeric($request->id)){

                $categoryItems = Product::where('category_id', $request->id )->take(8)->get();
                if (count($categoryItems)){
                    echo json_encode(['categoryItems' => $categoryItems, 'count' => count($categoryItems)]);exit();
                }else{
                    echo json_encode(['categoryItems' => false]);exit();
                }

            }

        }

    }


    public function loadMoreCategoryitems(){
        $request = Request::get('post');

        //CHECK TOKEN
        if(CSRFToken::checkToken($request->token, false)){

            //GET COUNT FROM HOME PAGE
            $count = $request->count;
            $itemPerPage = $count + $request->next;


            $categoryItems = Product::where('category_id', $request->id)->take($itemPerPage)->get();
            echo json_encode(['categoryItems' => $categoryItems, 'count' => count($categoryItems)]);
        }
    }


    public function termsAndConditions(){
        return view('/termsandconditions');
    }





}








?>