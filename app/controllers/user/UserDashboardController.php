<?php
/**
 * Created by PhpStorm.
 * User: Gravity
 * Date: 30/07/2018
 * Time: 11:20 AM
 */

namespace App\Controllers\User;


use App\Classes\Redirect;
use App\classes\Request;
use App\classes\Role;
use App\Classes\Session;
use App\Controllers\BaseController;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Capsule\Manager as Capsule;

class UserDashboardController extends BaseController
{


    public function __construct()
    {
        //REDIRECT USER TO LOGIN PAGE IS USER IS NOT ADMIN
        if (!Role::middleware('user')){
            Redirect::to('/login');
        }

    }

    public function show(){

        $orders = count(OrderDetail::where('user_id', user()->id)->get());
        $ordersPending = count(OrderDetail::where([['user_id', user()->id], ['status', 'pending']])->get());
        $ordersPaid = Payment::where('user_id', user()->id)->sum('amount');
        return view('user/user_dashboard', compact('orders', 'ordersPending', 'ordersPaid'));
    }

    public function getChartData(){
       $revenue = Capsule::table('payments')->where('user_id', \user()->id)->select(
           Capsule::raw('sum(amount) as `amount` '),
           Capsule::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"),
           Capsule::raw('YEAR(created_at) year, Month(created_at) month')
       )->groupby('year', 'month')->get();

        $orders = Capsule::table('orders')->where('user_id', \user()->id)->select(
            Capsule::raw('count(id) as `count` '),
            Capsule::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"),
            Capsule::raw('YEAR(created_at) year, Month(created_at) month')
        )->groupby('year', 'month')->get();

        echo json_encode(
            [
                'revenues' => $revenue,
                'orders' => $orders
                ]
        );
    }




}

?>