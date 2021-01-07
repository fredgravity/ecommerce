<?php
/**
 * Created by PhpStorm.
 * User: Gravity
 * Date: 14/11/2018
 * Time: 8:30 AM
 */

namespace App\controllers\admin;


use App\classes\Request;
use App\Controllers\BaseController;
use App\Classes\Redirect;
use App\classes\Role;
use App\Models\Payment;
use Illuminate\Database\Capsule\Manager as Capsule;

class PaymentController extends BaseController
{

    public function __construct()
    {
        //REDIRECT USER TO LOGIN PAGE IS USER IS NOT ADMIN
        if (!Role::middleware('admin')){

            Redirect::to('/login');
        }


    }

    public function showPayments(){
        $revenues = Capsule::table('payments')->selectRaw('sum(amount) as `amount`')->get();
        $revenue = $revenues[0]->amount;
        return view('/admin/products/paymentDashboard', compact('revenue'));
    }

    public function paymentConverter(){
        if (Request::exist('post')){
            $request = Request::get('post');
            $convert = $request->convert;
            $result = '';
            $amount = '';

            $payments = Capsule::table('payments')->select(
                Capsule::raw('sum(amount) as `amount`'))->get();
            foreach ($payments as $payment) {
                $amount = $payment->amount;
            }


            switch ($convert){
                case 'USD':
                    $result = '$ ' . number_format($amount * getenv('USD_RATE'), 2);
                    break;

                case 'GBP':
                    $result = '€ ' . number_format( $amount * getenv('GBP_RATE'), 2);
                    break;

                case 'EUR':
                    $result = '£ ' . number_format( $amount * getenv('EUR_RATE'), 2);
                    break;

                case 'ZAR':
                    $result = 'R ' . number_format( $amount * getenv('ZAR_RATE'), 2);
                    break;

                default:
                    //DO NOTHING
            }

//           pnd($result);
            echo json_encode(['rate' => $result]);
        }
    }

    public function paymentChart(){
        $payments = Capsule::table('payments')->select(
            Capsule::raw('sum(amount) as `amount`'),
            Capsule::raw("DATE_FORMAT(created_at, '%y-%m') `new_date`"),
            Capsule::raw('Year(created_at) `year`, Month(created_at) `month`')
        )->groupBy('year', 'month')->get();

        echo json_encode(['payments' => $payments]);
    }


}