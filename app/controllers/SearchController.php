<?php
/**
 * Created by PhpStorm.
 * User: Gravity
 * Date: 20/07/2018
 * Time: 4:35 PM
 */

namespace App\Controllers;



use App\Classes\CSRFToken;
use App\Classes\Mail;
use App\Classes\Redirect;
use App\classes\Request;
use App\Classes\Session;
use App\classes\ValidateRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;


class SearchController extends BaseController
{

    public $categories, $num = [], $subCategories, $advSearchRequest = [];

    public function __construct()
    {
        $this->categories = Category::all();
        $this->subCategories = SubCategory::all();

        $ids = Category::pluck('id', 'name');

        foreach ($ids as $id) {
            $this->num[] = Product::where('category_id', $id)->get()->count();
        }

    }

    public function show(){
        $categories = $this->categories;
        $subCategories = $this->subCategories;
        $totalItems = $this->num;

$results = [];
$searchWord = '';
        $token = CSRFToken::generate();
        $advance = '';

//                pnd($result);
        return view('/search', compact('categories', 'totalItems', 'results', 'searchWord', 'token', 'subCategories', 'advance'));

    }


    public function showSearch(){
        if(Request::exist('post')){
            $request = Request::get('post');

            $results = Product::where('name', 'LIKE' ,'%'.$request->word.'%')
                ->orWhere('description', 'LIKE' ,'%'.$request->word.'%')
                ->with(['category', 'subCategory', 'user'])->take(8)->get();

//                $categoryItems = Product::where('category_id', $request->id )->take(8)->get();
                if (count($results)){
                    echo json_encode(['categoryItems' => $results, 'count' => count($results)]);exit();
                }else{
                    echo json_encode(['categoryItems' => false]);exit();
                }



        }
    }


    public function searchProduct(){
        if (Request::exist('post')){
            $request = Request::get('post');
//pnd($request);
            if (CSRFToken::checkToken($request->token, false)){

                $rules = [
                    'searchField' => ['required' => true, 'string'=>true, 'minLength' => 3, 'maxLength' => 25],

                ];


                //VALIDATE THE FORM DATA AGAINST THE RULES
                $validator = new ValidateRequest;
                $validator->abide($_POST, $rules);

                if($validator->hasError()){
                    $errors = $validator->getErrorMessages();

                    $categories = $this->categories;
                    $subCategories = $this->subCategories;
                    $totalItems = $this->num;
                    $results = [];
                    $token = CSRFToken::generate();
                    $advance = "Advance Search";

                    return view('/advanceSearch', compact('categories', 'totalItems', 'results', 'token', 'subCategories', 'advance', 'errors'));
                }



                $categories = $this->categories;
                $subCategories = $this->subCategories;
                $totalItems = $this->num;
                ($request->searchField === '')? $search = false : $search = $request->searhField;


                $results = Product::where('name', 'LIKE' ,'%'.$search.'%')
                    ->orWhere('description', 'LIKE' ,'%'.$search.'%')
                    ->with(['category', 'subCategory', 'user'])->get();

                $searchWord = $request->searchField;
                $token = CSRFToken::generate();
                $advance = '';

//                pnd($result);
                return view('/search', compact('categories', 'totalItems', 'results', 'searchWord', 'token', 'subCategories', 'advance'));

            }
        }
        return false;
    }

    public function productSearch(){
        $request = Request::get('post');

        //CHECK TOKEN
        if(CSRFToken::checkToken($request->token, false)){

            //GET COUNT FROM HOME PAGE
            $count = $request->count;
            $itemPerPage = $count + $request->next;
            $word = $request->word;

            $results = Product::where('name', 'LIKE' ,'%'.$word.'%')
                ->orWhere('description', 'LIKE' ,'%'.$word.'%')
                ->with(['category', 'subCategory', 'user'])->take($itemPerPage)->get();

//            $categoryItems = Product::where('category_id', $request->id)->take($itemPerPage)->get();
            echo json_encode(['categoryItems' => $results, 'count' => count($results)]);
        }
    }


    public function advanceSearch(){

        if (Request::exist('post')){
            $request = Request::get('post');
            $this->advSearchRequest = Request::get('post');
//pnd($request);
            if (CSRFToken::checkToken($request->token, false)){

                $rules = [
                    'search' => ['required' => true, 'string'=>true, 'minLength' => 1, 'maxLength' => 20],
                    'min' => ['number' => true],
                    'max'=>['number' => true],
                    'category'=>['number'=>true,  'maxLength' => 20],
                    'subCategory'=>['number'=>true, 'maxLength' => 20 ],
                    'country'=>['required'=>true, 'string'=>true, 'minLength' => 4, 'maxLength' => 20,]
                ];


                //VALIDATE THE FORM DATA AGAINST THE RULES
                $validator = new ValidateRequest;
                $validator->abide($_POST, $rules);

                if($validator->hasError()){
                    $errors = $validator->getErrorMessages();

                    $categories = $this->categories;
                    $subCategories = $this->subCategories;
                    $totalItems = $this->num;
                    $results = [];
                    $token = CSRFToken::generate();
                    $advance = "Advance Search";

                    return view('/advanceSearch', compact('categories', 'totalItems', 'results', 'token', 'subCategories', 'advance', 'errors'));
                }

                //GET DATA FROM ADVANCE SEARCH

                $categories = $this->categories;
                $subCategories = $this->subCategories;
                $totalItems = $this->num;


                $results = $this->getAdvSearch($request);


                $token = CSRFToken::generate();
                $advance = "Advance Search";

                return view('/advanceSearch', compact('categories', 'totalItems', 'results', 'token', 'subCategories', 'advance', 'errors'));
            }
        }

        return false;

    }


    public function getAdvSearch($request, $count = ''){
//pnd($request);
        $category = $request->category;
        $subCategory = $request->subCategory;
        $max = $request->max;
        $itemPerPage = 6 + (int)$count;
        $results = [];
//pnd($itemPerPage);
        if (empty($category) && empty($subCategory) && empty($max)){
//pnd('hi');
            $results = Product::where(
                [
                    ['name', 'LIKE', '%'.$request->search.'%'],
                    ['price', '>=', $request->min ],

                ]
            )->with(['category', 'subCategory', 'user'])->take($itemPerPage)->orderBy('id', 'desc')->get();

        }elseif (empty($category) && empty($subCategory)){
//            pnd('hi2');
            $results = Product::where(
                [
                    ['name', 'LIKE', '%'.$request->search.'%'],
                    ['price', '>=', $request->min ],
                    ['price', '<=', $request->max ],

                ]
            )->with(['category', 'subCategory', 'user'])->take($itemPerPage)->orderBy('id', 'desc')->get();


        }elseif (empty($category) && empty($max)){
//            pnd('hi3');
            $results = Product::where(
                [
                    ['name', 'LIKE', '%'.$request->search.'%'],
                    ['sub_category_id', $request->subCategory],
                    ['price', '>=', $request->min ],


                ]
            )->with(['category', 'subCategory', 'user'])->take($itemPerPage)->orderBy('id', 'desc')->get();

        }elseif (empty($subCategory)){
//            pnd('hi4');
            $results = Product::where(
                [
                    ['name', 'LIKE', '%'.$request->search.'%'],
                    ['category_id', $request->category],
                    ['price', '>=', $request->min ],
                    ['price', '<=', $request->max ],

                ]
            )->with(['category', 'subCategory', 'user'])->take($itemPerPage)->orderBy('id', 'desc')->get();

        }elseif (empty($subCategory) && empty($max)){
//            pnd('hi5');
            $results = Product::where(
                [
                    ['name', 'LIKE', '%'.$request->search.'%'],
                    ['category_id', $request->category],
                    ['price', '>=', $request->min ],
                ]
            )->with(['category', 'subCategory', 'user'])->take($itemPerPage)->orderBy('id', 'desc')->get();

        }elseif (empty($category)){
//            pnd('hi6');
            $results = Product::where(
                [
                    ['name', 'LIKE', '%'.$request->search.'%'],
                    ['sub_category_id', $request->subCategory],
                    ['price', '>=', $request->min ],
                    ['price', '<=', $request->max ],
                ]
            )->with(['category', 'subCategory', 'user'])->take($itemPerPage)->orderBy('id', 'desc')->get();

        }elseif ( empty($max)){
//            pnd('hi7');
            $results = Product::where(
                [
                    ['name', 'LIKE', '%'.$request->search.'%'],
                    ['category_id', $request->category],
                    ['price', '>=', $request->min ],
                    ['sub_category_id', $request->subCategory],

                ]
            )->with(['category', 'subCategory', 'user'])->take($itemPerPage)->orderBy('id', 'desc')->get();

        }else{
//            pnd('hi8');
            $results = Product::where(
                [
                    ['name', 'LIKE', '%'.$request->search.'%'],
                    ['category_id', $request->category],
                    ['sub_category_id', $request->subCategory],
                    ['price', '>=', $request->min ],
                    ['price', '<=', $request->max ],

                ]
            )->with(['category', 'subCategory', 'user'])->take($itemPerPage)->orderBy('id', 'desc')->get();
        }

        return $results;
    }



    public function getSubcategory($id){
        $subCategories = SubCategory::where('category_id', $id)->get();
        echo json_encode($subCategories); exit();
    }


    public function loadMore(){
        $request = Request::get('post');
//        $oldReq = $this->advSearchRequest;

        //CHECK TOKEN
        if(CSRFToken::checkToken($request->token, false)){

            //GET COUNT FROM HOME PAGE
            $count = $request->count;
            $itemPerPage = $count + $request->next;
//            pnd($request);
            $results = $this->getAdvSearch($request,$itemPerPage);

//pnd(count($results));


            echo json_encode(['results' => $results, 'count' => count($results)]);

//            $subItems = Product::where('sub_category_id', $request->id)->take($itemPerPage)->get();
//            echo json_encode(['subItems' => $subItems, 'count' => count($subItems)]);
        }
    }



}








?>