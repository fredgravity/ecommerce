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
use App\Classes\UploadFile;
use App\classes\ValidateRequest;
use App\Controllers\BaseController;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Capsule\Manager as Capsule;


class OrderController extends BaseController
{

    public $tableName = 'orders', $orders, $catLinks, $subcategory, $users,  $orderLinks, $search;
    private $_data, $_tmpFile;

    public function __construct()
    {

        //REDIRECT USER TO LOGIN PAGE IS USER IS NOT ADMIN
        if (!Role::middleware('admin')){
            Redirect::to('/login');
        }

        $this->orders = Order::all();
        $orderObj = new Order;
        $this->users = User::all();
        $total = $orderObj->all()->count();

        //PRODUCT DB DATA AND PAGINATION
        list($this->orders, $this->orderLinks) = paginate(10, $total, $this->tableName, $orderObj);

    }

    public function show(){
        $orders = $this->orders;
        $users = $this->users;
        $orderLinks = $this->orderLinks;
//      $details = OrderDetail::all();


//      pnd($orders);
        view('admin/products/order', compact('orders', 'orderLinks', 'users'));
    }


    public function showCreateProductForm(){
        $categories = $this->categories;
        return view('admin/products/create', compact('categories'));

    }



    public function loadOrderDetails(){
        if (Request::exist('post')){
            $request = Request::get('post');

            if (CSRFToken::checkToken($request->token, false)){

                $orders = Order::find($request->orderId);
                $users = $orders->user;
                $orderDetails = $orders->orderDetail;

                echo json_encode(['orders' => $orders, 'users' => $users, 'orderDetails' => $orderDetails]);
            }else{
                $env = getenv('APP_ENV');
                if($env === 'local'){
                    throw new \Exception('Token Mismatch');
                }
            }


        }
        return null;
    }


    public function productDetails(){
        if (Request::exist('post')){
            $request = Request::get('post');
//            pnd($request);

            $products = Product::find($request->productID);
//            pnd($products);

            echo json_encode(['products' => $products]);

        }else{
            $env = getenv('APP_ENV');
            if($env === 'local'){
                throw new \Exception('Token Mismatch');
            }
        }
        return null;
    }




    public function showEditOrderForm($id){
        $orderDetails = OrderDetail::where('id', $id)->with(['user', 'order', 'product', 'category', 'subCategory'])->get();

        return view('/admin/products/editOrder', compact('orderDetails'));

    }


    public function deleteOrder($id){

        if(Request::exist('post')){
            $request = Request::get('post');

            //CHECK TOKEN
            if(CSRFToken::checkToken($request->token,false)){


               //DELETE ALL ORDER DETAILS RELATED TO THIS PARTICULAR ORDER
                $orders = Order::where('id', $id)->with('orderDetail')->get();
                if ($orders){
                    foreach ($orders as $order) {
                        foreach ($order->orderDetail as $orderDetail){
                            $orderDetail->delete();
                        }

                        $order->delete();
                    }
                }



               Session::flash('success', 'Order Deleted Successfully');
               Redirect::to('/admin/orders');

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


    public function deleteOrderDetails($id){

        if(Request::exist('post')){
            $request = Request::get('post');

            //CHECK TOKEN
            if(CSRFToken::checkToken($request->token,false)){
                //SOFT DELETE CATEGORY
                OrderDetail::destroy($id);


                Session::flash('success', 'Order Detail Deleted Successfully');
                Redirect::to('/admin/orders');

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


    public function updateEditOrderForm ($id){
        if (Request::exist('post')){
            $request = Request::get('post');


            if (CSRFToken::checkToken($request->token)){


                $rules = [
                  'quantity' =>['required'=>true, 'number'=>true, 'maxLength'=>2],
                    'status' =>['required'=> true, 'string'=>true]
                ];

                $validation = new ValidateRequest;
                $validation->abide($_POST, $rules);

                //CHECK FOR VALIDATION ERRORS
                if ($validation->hasError()){
                    $orderDetails = OrderDetail::where('id', $id)->with(['user', 'order', 'product', 'category', 'subCategory'])->get();
                    $errors = $validation->getErrorMessages();
                    return view('/admin/products/editOrder', compact('orderDetails', 'errors'));
                }

                //CHECK IF UNIT PRICE AND ID IS IN THE ORDER DETAILS TABLE
                $total = $request->unit_price * $request->quantity;

                if (OrderDetail::find($id)->where('unit_price', $request->unit_price)){
                    OrderDetail::where('id', $id)->update(['total' => $total, 'status' => $request->status, 'quantity'=>$request->quantity]);
                    $orderDetails = OrderDetail::where('id', $id)->with(['user', 'order', 'product', 'category', 'subCategory'])->get();

                    Session::flash('success', 'Order details has been updated successfully');

                    Request::refresh();
                    return view('/admin/products/editOrder', compact('orderDetails'));
                }

//
               return null;

            }else{

                Redirect::to('/admin/orders');
            }

        }
    return null;
    }

    public function searchOrders(){
        if (Request::exist('post')){
            $request = Request::get('post');

            if (CSRFToken::checkToken($request->token, false)){
              $search = $request->search;
                $searchOrder = Order::where('order_id', 'LIKE', "%$search%")->with(['orderDetail', 'user'])->get();

                echo json_encode(['searchResults' => $searchOrder]);


            }else{
                $env = getenv('APP_ENV');
                if($env === 'local'){
                    throw new \Exception('Token Mismatch');
                }
                $this->show();


            }

        }

        return null;
    }







}
?>