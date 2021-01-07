<?php
/**
 * Created by PhpStorm.
 * User: Gravity
 * Date: 07/08/2018
 * Time: 9:11 AM
 */

namespace App\controllers\User;


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
use App\models\Rating;
use App\Models\SubCategory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Capsule\Manager as Capsule;


class UserOrderController extends BaseController
{

    public $tableName = 'order_details', $orders, $catLinks, $subcategory, $users,  $orderLinks, $search, $orderDetails, $rating;
    private $_data, $_tmpFile;

    function __construct()
    {

        //REDIRECT USER TO LOGIN PAGE IS USER IS NOT ADMIN
        if (!Role::middleware('user')){
            Redirect::to('/login');
        }

        $this->orderDetails = OrderDetail::where('user_id', user()->id)->with('product')->orderBy('id', 'desc')->get();
        $orderObj = new OrderDetail();
        $this->users = User::all();
        $total = count($this->orders);
        $this->rating = Rating::where('user_id', \user()->id)->orderBy('id', 'desc')->get();

        //PRODUCT DB DATA AND PAGINATION
        list($this->orders, $this->orderLinks) = paginate(10, $total, $this->tableName, $orderObj, '',user()->id);

    }

    public function show(){
        $orderDetails = $this->orders;
        $orderDetailsWithProduct = $this->orderDetails;
        $ratings = $this->rating;
        $orderDetailsLinks = $this->orderLinks;

        view('user/products/userOrder', compact('orderDetails', 'orderDetailsLinks', 'orderDetailsWithProduct', 'ratings'));
    }



    public function deleteOrder($id){

        if(Request::exist('post')){
            $request = Request::get('post');

            //CHECK TOKEN
            if(CSRFToken::checkToken($request->token,false)){

               //DELETE ALL ORDER DETAILS RELATED TO THIS PARTICULAR ORDER

                if (OrderDetail::where('id', $id)->delete()){
                    Session::flash('success', 'Order Deleted Successfully');
                    Redirect::to('/user/orderDetails');
                }else{
                    Session::flash('error', 'Order Deleted Unsuccessfully');
                    Redirect::to('/user/orderDetails');
                }



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


    public function searchOrders(){
        if (Request::exist('post')){
            $request = Request::get('post');

            if (CSRFToken::checkToken($request->token, false)){
              $search = $request->search;
                $searchOrder = OrderDetail::where([['order_id', 'LIKE', "%$search%"], ['user_id', \user()->id]])
                    ->orWhere([['status', 'LIKE', "%$search%"], ['user_id', \user()->id]])
                    ->with(['product'])->orderBy('id', 'desc')->get();

                if (count($searchOrder) < 1){
                    $searchOrderProduct = Product::where('name', 'LIKE', "%$search%")->get();
                    $ids = [];
                    foreach ($searchOrderProduct as $item) {
                        array_push($ids, $item->id);
                    }

                    $searchOrder = OrderDetail::whereIn('product_id', $ids)
                        ->with(['product'])->get();

                }

                echo json_encode(['searchResults' => $searchOrder, 'userId' => \user()->id]);


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



    public function rating(){
        if (Request::exist('post')){
            $request = Request::get('post');
//pnd($request);
            if (CSRFToken::checkToken($request->token, false)){
                //GET VENDOR ID USING PRODUCT ID
                $vendor = Product::where('id', $request->productId)->first();
//                pnd($vendor->user_id);
                if (count($vendor)){
                    Rating::updateOrCreate(
                        ['user_id' => \user()->id , 'vendor_id' => $vendor->user_id, 'product_id' => $request->productId],
                        ['rating' => $request->rating]
                    );

                    echo json_encode(['res' => "You have rated this product $request->rating"]);
                }
                return false;
            }
        }
        return false;
    }


    public function getRating(){
        $rating = Rating::where('user_id', \user()->id)->orderBy('id', 'desc')->get();
        echo json_encode(['res' => $rating]);
    }


}
?>