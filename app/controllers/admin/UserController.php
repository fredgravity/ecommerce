<?php
/**
 * Created by PhpStorm.
 * User: Gravity
 * Date: 30/07/2018
 * Time: 11:20 AM
 */

namespace App\Controllers\Admin;


use App\Classes\CSRFToken;
use App\classes\MailingWithGun;
use App\Classes\Redirect;
use App\classes\Request;
use App\classes\Role;
use App\Classes\Session;
use App\Classes\UploadFile;
use App\classes\ValidateRequest;
use App\Controllers\BaseController;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Capsule\Manager as Capsule;

class UserController extends BaseController
{

    public $tableName = 'users', $users, $usersLink, $search, $editUser, $vendors, $vendorsLink;

    public function __construct()
    {
        //REDIRECT USER TO LOGIN PAGE IS USER IS NOT ADMIN
        if (!Role::middleware('admin')){
            Redirect::to('/login');
        }

        $total = User::where('role', 'user')->count();
        $total = User::where('role', 'vendor')->count();
        $userObj = new User;
        $user = User::where('role', 'user')->with('vendorDetail')->get();
        $vendor = User::where('role', 'vendor')->with('vendorDetail')->get();

        list($this->users, $this->usersLink) = paginate(10, $total, $this->tableName, $userObj, '', '', $user);
        list($this->vendors, $this->vendorsLink) = paginateWithDetails(10, $total, $this->tableName, $userObj, '', '', $vendor);
    }

    public function show(){

        $users = $this->users;
        $links = $this->usersLink;
        $role = 'user';
        return view('admin/products/user', compact('users', 'links', 'role'));
    }


    public function showVendors(){

        $users = $this->vendors;
        $links = $this->vendorsLink;
        $role = 'vendor';
        return view('admin/products/user', compact('users', 'links', 'role'));
    }


    public function showDashboard(){

        $allUsers = User::all()->count();
        $totalUsers = User::where('role', 'user')->count();
        $totalVendors = User::where('role', 'vendor')->count();

        return view('admin/products/userDashboard', compact('allUsers', 'totalUsers', 'totalVendors'));
    }

    public function getChartData(){
        $subscribers = Capsule::table('users')->select(
            Capsule::raw('count(id) as `count` '),
            Capsule::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"),
            Capsule::raw('YEAR(created_at) year, Month(created_at) month')
        )->groupby('year', 'month')->get();

        $users = Capsule::table('users')->where('role', '=', 'user')->select(
            Capsule::raw('count(id) as `count` '),
            Capsule::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"),
            Capsule::raw('YEAR(created_at) year, Month(created_at) month')
        )->groupby('year', 'month')->get();

        $vendors = Capsule::table('users')->where('role', '=', 'vendor')->select(
            Capsule::raw('count(id) as `count` '),
            Capsule::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"),
            Capsule::raw('YEAR(created_at) year, Month(created_at) month')
        )->groupby('year', 'month')->get();

        echo json_encode(
            [
                'subscribers' => $subscribers,
                'users' => $users,
                'vendors' => $vendors

                ]
        );
    }

    public function deleteUser($id){
        if (Request::exist('post')){
            $request = Request::get('post');

            if (CSRFToken::checkToken($request->token, false)){

                $role = $this->getRole($id);
                //GET USER ROLE AND DELETE USER
                if($role === 'user'){
                    User::where('id', $id)->delete();
                    Session::flash('success', 'User Deleted Successfully');
                    Redirect::to('/admin/users-details');
                }elseif ($role === 'vendor'){
                    User::where('id', $id)->delete();
                    Session::flash('success', 'Vendor Deleted Successfully');
                    Redirect::to('/admin/vendors-details');
                }


            }else{
                if (getenv('APP_ENV') !== 'production'){
                    die('Malicious Activity detected');
                }
            }

        }
        return null;
    }

    public function searchUser(){
        if (Request::exist('post')){
            $request = Request::get('post');

            if (CSRFToken::checkToken($request->token, false)){
                $search = $request->search;
                $role = $request->role;

                $searchUser = User::where([ ['username', 'LIKE', "%$search%"], ['role', '=', $role]] )
                    ->orWhere([['fullname', 'LIKE', "%$search%"], ['role', '=', $role]])
                    ->orWhere([['email', 'LIKE', "%$search%"], ['role', '=', $role]] )
                    ->orWhere([['country_name', 'LIKE', "%$search%"], ['role', '=', $role]] )->get();

                echo json_encode(['search' => $searchUser]);

            }
        }
        return null;
    }


    public function editUser($id){

        $users = $this->getUser($id);
        return view('/admin/products/editUser', compact('users'));
    }



    public function updateUser($id){
        if(Request::exist('post')){
            $request = Request::get('post');
            $fileError = [];
//pnd($request);
            if(CSRFToken::checkToken($request->token, false)){

                $rules = [

                    'fullname' => ['required' => true, 'minLength' => 6, 'maxLength' => 50, 'string' => true],
                    'address' => ['required' => true, 'minLength' => 4, 'maxLength' => 500, 'mixed' => true],
                    'country' => ['required' => true, 'minLength' => 4, 'maxLength' => 50, 'string' => true],
                    'region' => ['required' => true, 'minLength' => 3, 'maxLength' => 50, 'string' => true],
                    'phone' => ['required' => true, 'minLength' => 4, 'maxLength' => 15, 'number' => true],
//                    'username' => ['required' => true, 'minLength' => 4, 'maxLength' => 15, 'mixed' => true, 'unique'=> true],
                ];

                $validate = new ValidateRequest;
                $validate->abide($_POST, $rules);

                //VALIDATE UPLOADED FILE
                $file = Request::get('file');
                $imagePath = '';
                //UPDATE PROFILE IMAGE IF AN IMAGE HAS BEEN PROVIDED
                isset($file->upload->name)? $filename = $file->upload->name : $filename = '';

                if($filename !== '') {
                    if (empty($filename)) {
                        $fileError['fileImage'] = 'The user image is required';
                    } elseif (!UploadFile::isImage($filename)) {
                        $fileError['fileImage'] = 'Please make sure the file is an image';
                    }
                }

                if (!$file->upload->tmp_name) {
                    if (!user()->image_path){
                        $fileError['fileImage'] = 'Please select image file again';
                    }else{
                        //CREATE IMAGE PATH
                        $imagePath = user()->image_path;

                    }

                }else{

                    if ( User::where([['id', $id], ['username', $request->username]])->count() ){
                        $tmpFile = $file->upload->tmp_name;
                        $optimideTo = "images" .DS. 'optimiseImages'. DS . "uploads".DS. 'users_pics'. DS . user()->username;
                        $folder = 'images'. DS . 'uploads'. DS . 'users'. DS . $request->username. DS . 'profile_pic';
                        //CREATE IMAGE PATH
                        $imagePath = UploadFile::move($tmpFile, $folder, $optimideTo, $filename, 'profile_pic')->optimisedPath();

                    }


                }


                if ($validate->hasError() || count($fileError)){

                    $response = $validate->getErrorMessages();
                    count($fileError)? $errors = array_merge($response, $fileError) : $errors = $response;

                    if (count($errors)){
                        $users = $this->getUser($id);
                        return view('/admin/products/editUser', ['users'=>$users, 'errors'=>$errors]);
                    }

                }



                $user = User::where([['role', 'user'], ['id', $id]])->orWhere([['role', 'vendor'], ['id', $id]])
                    ->update(
                        [
                            'fullname' => $request->fullname,
                            'country_name' => $request->country,
                            'state_name' => $request->state,
                            'phone' => $request->phone,
                            'city' => $request->city,
                            'image_path' => $imagePath,
                            'username' => $request->username
                        ]
                    );

                if ($user){

                    Session::flash('success', 'User details has been updated successfully');
                    foreach ($id as $i){
                        Redirect::to('/admin/user/'.$i.'/edit');
                    }

                }

            }

        }

        return null;

    }



    public function changePassword($id){
        if(Request::exist('post')){
            $request = Request::get('post');

            if(CSRFToken::checkToken($request->token, false)){

                $rules = [
                        'old_password' => ['required' => true, 'minLength' => 6],
                        'new_password' => ['required' => true, 'minLength' => 6],
                        'confirm_password' => ['required' => true, 'minLength' => 6],
                ];

                $validation = new ValidateRequest;
                $validation->abide($_POST, $rules);

                if($validation->hasError()){
                    $errors = $validation->getErrorMessages();

                    $users = $this->getUser($id);
                    return view('/admin/products/editUser', compact('users', 'errors' ));
                }


                $user = User::select('password')->where([['role', 'user'], ['id', $id]])->orWhere([['role', 'vendor'], ['id', $id]])->get();

                if($request->new_password === $request->confirm_password){

                    foreach ($user as $password){
                        if (password_verify($request->old_password, $password->password)){

                            $newPassword = password_hash($request->new_password, PASSWORD_BCRYPT);
                            $user = User::where([['role', 'user'], ['id', $id]])->orWhere([['role', 'vendor'], ['id', $id]])->update(['password' => $newPassword]);

                            if ($user){

                                Session::flash('success', 'Your password has been changed successfully');
                                foreach ($id as $i){
                                    Redirect::to('/admin/user/'.$i.'/edit');
                                }

                            }

                        }else{
                            Session::flash('error', 'Please Enter a valid old password');
                            $users = $this->getUser($id);
                            return view('/admin/products/editUser', compact('users'));
                        }


                    }

                }

                Session::flash('error', 'Please make sure your confirm password matches your new password');
                $users = $this->getUser($id);
                return view('/admin/products/editUser', compact('users'));
            }

        }

        return null;
    }

    public function sendBroadcast(){
        if (Request::exist('post')){
            $request = Request::get('post');

            if (CSRFToken::checkToken($request->token, false)){

                $rules = [
                    'email' => ['required'=>true, ],
                    'subject' => ['required'=>true, 'string'=>true, 'minLength'=>3, 'maxLength'=>20],
                    'message' => ['required'=>true, 'mixed'=>true , 'minLength'=>3, 'maxLength'=>200],
                    'mailList' => ['required'=>true, 'string'=>true, 'minLength'=>3, 'maxLength'=>6 ]
                ];

                //VALIDATE INPUT FORM
                $validator = new ValidateRequest;
                $validator->abide($_POST, $rules);

                if ($validator->hasError()){
                    $errors = $validator->getErrorMessages();

                    return view('/admin/products/broadcast', compact('errors'));
                }




                $data = [
                    'from'      => $request->email,
                    'subject'   => $request->subject,
                    'message'   => $request->message,
                    'view'      => 'broadcast'
                ];

//TODO:uncomment this after domain has been set for mailgun to braodcast to mailing list
//                UserController::sendToMailingList($data, $request->mailList);

                Session::flash('success', "Message has been broadcast to $request->mailList mailing list.");
                Redirect::to('/admin/broadcast-email');

            }
        }
    }


    public function showBroadcastForm(){
        $userMailList = getenv('MAILGUN_MAILING_LIST_USERS');
        $vendorMailList = getenv('MAILGUN_MAILING_LIST_VENDORS');

       return view('/admin/products/broadcast', compact('userMailList', 'vendorMailList'));
    }



    public function getUser($id){
        return User::where([['role', 'user'], ['id', $id]])->orWhere([['role', 'vendor'], ['id', $id]])->get();
    }


    public function getRole($id){
        $user = User::find($id);
        foreach ($user as $role){
            return $role->role;

        }
       return null;
    }

    public static function sendToMailingList($data, $role){
        $mailingList = new MailingWithGun;
        $mailingList->sendToMailingList($data, $role);
        return new static;
    }



}

?>