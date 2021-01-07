<?php
/**
 * Created by PhpStorm.
 * User: Gravity
 * Date: 30/07/2018
 * Time: 11:20 AM
 */

namespace App\Controllers\Admin;


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

class DashboardController extends BaseController
{

    public function __construct()
    {
        //REDIRECT USER TO LOGIN PAGE IS USER IS NOT ADMIN
        if (!Role::middleware('admin')){
            Redirect::to('/login');
        }
    }

    public function show(){

//        $orders = Capsule::table('orders')->count(Capsule::raw('DISTINCT order_no'));
        $orders = Order::all()->count();
        $products = Product::all()->count();
        $users = User::all()->count();
        $payments = Payment::all()->sum('amount');

        return view('admin/dashboard', compact('orders', 'products', 'users', 'payments'));
    }

    public function getChartData(){
       $revenue = Capsule::table('payments')->select(
           Capsule::raw('sum(amount) as `amount` '),
           Capsule::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"),
           Capsule::raw('YEAR(created_at) year, Month(created_at) month')
       )->groupby('year', 'month')->get();

        $orders = Capsule::table('orders')->select(
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