<?php
/**
 * Created by PhpStorm.
 * User: gravity
 * Date: 12/14/2018
 * Time: 2:37 PM
 */

namespace App\controllers\admin;


use App\Classes\Redirect;
use App\classes\Role;
use App\Controllers\BaseController;
use App\Models\User;
use App\classes\Request;
use App\Classes\CSRFToken;
use App\models\VendorDetail;

class ValidateAccountsController extends BaseController
{

    public $vendors, $vendorsLink, $tableName='users';

    public function __construct()
    {


        if(!Role::middleware('admin')){
            Redirect::to('/');
        }
        $userObj = new User;
        $total = User::where('role', 'vendor')->count();
        $qryData = User::where('role', 'vendor')->with('vendorDetail')->get();

        list($this->vendors, $this->vendorsLink) = paginateWithDetails(10, $total, $this->tableName, $userObj, '', '', $qryData);
//        pnd($this->vendorsLink);
    }

    public function show(){
        $users = $this->vendors;
        $links = $this->vendorsLink;
        $role = 'vendor';
        return view('admin/products/verifyVendor', compact('users', 'links', 'role'));
    }

    public function validateCerts(){

    }


    public function search(){
        if (Request::exist('post')){
            $request = Request::get('post');
//pnd($request);
            if (CSRFToken::checkToken($request->token, false)){
                $search = $request->search;
                $role = $request->role;

                $searchUser = User::where([ ['username', 'LIKE', "%$search%"], ['role', '=', $role]] )->with('vendorDetail')
                    ->orWhere([['fullname', 'LIKE', "%$search%"], ['role', '=', $role]])->with('vendorDetail')
                    ->orWhere([['email', 'LIKE', "%$search%"], ['role', '=', $role]] )->with('vendorDetail')
                    ->orWhere([['country_name', 'LIKE', "%$search%"], ['role', '=', $role]] )->with('vendorDetail')->get();

                echo json_encode(['search' => $searchUser]);

            }
        }
        return null;
    }


    public function approval(){
        if (Request::exist('post')){
            $request = Request::get('post');
//pnd($request);
            if (    CSRFToken::checkToken($request->token, false)){
                if ($request->check === 'true'){
                    VendorDetail::where('user_id', $request->user)->update(['approval'=> 1]);
                    echo json_encode(['msg' => 'Certification has been approved ', 'user'=>$request->user]);
                    exit();
                }
                VendorDetail::where('user_id', $request->user)->update(['approval'=> 0]);
                echo json_encode(['msg' => 'Certification has  been denied ', 'user'=>$request->user]);
                exit();

            }
        }
    }


    public function getCheckboxStatus(){

        $users = VendorDetail::all();
        $app = [];
        foreach ($users as $user) {

            if ($user->approval === 1){
                array_push($app, $user->user_id);

            }
        }
        echo json_encode(['app' => true, 'user'=>$app]);


    }









}

?>