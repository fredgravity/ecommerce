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
use App\classes\MailingWithGun;
use App\Classes\Redirect;
use App\classes\Request;
use App\Classes\Session;
use App\classes\ValidateRequest;
use App\Models\Category;
use App\models\Comment;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\models\Rating;
use App\Models\User;

class ProductController extends BaseController
{




    public function show($id){
        //GENERATE TOKEN FOR HOME PAGE
        $token = CSRFToken::generate();

        $categories = Category::all();
        $product = Product::where('id', $id)->with('user')->first();

        return view('/product', compact('token', 'product', 'categories'));

    }

    public function get($id){
        $product = Product::where('id', $id)->with(['category', 'subCategory', 'user'])->first();

        //CHECK IF PRODUCT EXIST
        if($product){

            $comments = Comment::where('vendor_id', $product->user->id )->with('user')->orderBy('id','desc')->get();
            $getRating = Rating::where('product_id', $id)->avg('rating');
//dnd(!count($getRating));
            (!count($getRating))? $rating = 0 : $rating = count($getRating);


            //GET RANDOM SIMILAR PRODUCTS OF THE SAME CATEGORY
            $similarProducts = Product::where('category_id', $product->category_id)->where('id', '!=', $id)->inRandomOrder()->limit(6)->get();


            echo json_encode([
                'product' => $product,
                'category' => $product->category,
                'subCategory' => $product->subCategory,
                'similarProducts' => $similarProducts,
                'comments' => $comments,
                'rating' => $rating
            ]);
            exit();
        }

        //OTHERWISE
        header('HTTP/1.1 422 Unprocessable Entity', true, 422);
        echo 'Product not found'; exit();
    }

    public function getProductLocation($id){
        $product = Product::where('id', $id)->with(['user'])->first();

        //CHECK IF PRODUCT EXIST
        if($product){

            echo json_encode([
                'product' => $product,
            ]);
            exit();
        }

        //OTHERWISE
        header('HTTP/1.1 422 Unprocessable Entity', true, 422);
        echo 'Product not found'; exit();
//        echo json_encode(['location' => 'tema Ghana']);
    }

    public function contactVendor($id){

        if (Request::exist('post')){
            $request = Request::get('post');

            if (CSRFToken::checkToken($request->token, false)){

                //CHECK IF USERNAME AND EMAIL IS THAT OF THE USER

                if ($request->username === \user()->username && $request->email === \user()->email){

                    //CHECK IF VENDOR ID AND PRODUCT NAME EXIST IN PRODUCT DB
                    $products = Product::where([['user_id', $id], ['name', $request->product_name]])->with('user')->get();
//                    pnd($products);
                    if ($products->count()){

                        $details = $this->createData($products, $request);

                        //SEND EMAIL TO CUSTOMER
                        $customerData = [
                            'to' => \user()->email,
                            'subject' => "Product Order ". $details['orderId'],
                            'view' => 'customerOrder',
                            'name' => $details['username'],
                            'body' => $details
                        ];

                            //SEND EMAIL TO VENDOR
                        $vendorData = [
                            'to' => $details['email'],
                            'subject' => "Product Order ". $details['orderId'],
                            'view' => 'vendorOrder',
                            'name' => \user()->fullname,
                            'body' => $details
                        ];

                            ProductController::emailCustomer($customerData);
                            ProductController::emailCustomer($vendorData);

                            Session::flash('success', 'The product '.($details['orderId']).' has been ordered successfully');
                            Redirect::to('/product/'.$id['id']);

                        }




                    }
                }





            }
        }



    public function createData($products, $request){
        //SEND THE VENDOR AND CUSTOMER THE ORDER EMAIL
        $details = [];
        $invoiceId = strtoupper( 'inv'.mt_rand(1000000, 9999999));
        foreach ($products as $product) {
            $details['email'] = $product->user->email;
            $details['username'] = $product->user->username;
            $details['country'] = $product->user->country_name;
            $details['productImg'] = $product->image_path;
            $details['productName'] = $product->name;
            $details['quantity'] = $request->quantity;
            $details['price'] = $product->price;
            $details['total'] = $product->price * $request->quantity;
            $details['orderId'] = $invoiceId;
            $details['custName'] = \user()->fullname;
            $details['custEmail'] = \user()->email;
            $details['custPhone'] = \user()->phone;
            $details['custCountry'] = \user()->country_name;

//            pnd($product->user->id);
            //CREATE ORDER DETAILS

            OrderDetail::create([
                'user_id' => user()->id,
                'product_id' => $product->id,
                'vendor_id' => $product->user->id,
                'unit_price' => $product->price,
                'quantity' => $request->quantity,
                'total' => $product->price * $request->quantity,
                'status' => 'pending',
                'order_id' => $invoiceId
            ]);

            //CREATE ORDER
            Order::create([
                'user_id' => user()->id,
                'order_id' => $invoiceId,
                'vendor_id' => $product->user->id
            ]);
        }

        return $details;


    }


    public static function emailCustomer($data){
        $mail = new MailingWithGun();
        $mail->send($data);
        return new static();
    }


    public function comment(){

        if (Request::exist('post')){
            $request = Request::get('post');
//pnd($request);
            if (CSRFToken::checkToken($request->token, false)){
                $rules = [
                  'comment' => ['required'=>true, 'string'=>true, 'minLength'=>3, 'maxLength'=>300]
                ];

                //VALIDATE THE FORMS AGAINST THE RULES
                $validator = new ValidateRequest;
                $validator->abide($_POST, $rules);

                //CHECK IF VALIDATION HAS ERRORS
                if ($validator->hasError()){
                    $errors = $validator->getErrorMessages();
                    echo json_encode(['resFailed'=>$errors['comment'][0]]); exit();
                }

                //CHECk IF PRODUCT ID BELONG TO THE RIGHT VENDOR
                $check = Product::where([['id', $request->productId], ['user_id', $request->vendorId]])->first();
//dnd($check);
                if ($check){
                    //INSERT COMMENT INTO DB
                    $comments = Comment::create(
                        [
                            'user_id' => \user()->id,
                            'vendor_id' => $request->vendorId,
                            'product_id' => $request->productId,
                            'comment' => $request->comment
                        ]
                    );

                    if ($comments){
                        $comments = Comment::where('vendor_id', $request->vendorId )->with('user')->orderBy('id','desc')->get();
                        echo json_encode(['res' => 'Comment has been posted successfully', 'comments'=>$comments]); exit();
                    }
                    return false;
                }

                return false;

            }

        }
        return false;
    }



    }








?>