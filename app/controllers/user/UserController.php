<?php
/**
 * Created by PhpStorm.
 * User: Gravity
 * Date: 30/07/2018
 * Time: 11:20 AM
 */

namespace App\Controllers\User;


use App\Classes\CSRFToken;
use App\Classes\Redirect;
use App\classes\Request;
use App\classes\Role;
use App\Classes\Session;
use App\Classes\UploadFile;
use App\classes\ValidateRequest;
use App\Controllers\BaseController;
use App\Models\User;
use Illuminate\Database\Capsule\Manager as Capsule;

class UserController extends BaseController
{

    public $tableName = 'users', $users, $usersLink, $search, $editUser, $vendors, $vendorsLink;

    public function __construct()
    {
        //REDIRECT USER TO LOGIN PAGE IS USER IS NOT ADMIN
        if (!Role::middleware('user')){
            Redirect::to('/login');
        }
        $this->users = User::find(\user()->id);

    }

    public function show(){

        $user = $this->users;
        return view('user/products/editUser', compact('user'));
    }


    public function showVendors(){

        $users = $this->vendors;
        $links = $this->vendorsLink;
        $role = 'vendor';
        return view('admin/products/user', compact('users', 'links', 'role'));
    }


    public function updateUser($id){
        if(Request::exist('post')){
            $request = Request::get('post');
            $fileError = [];

            if( ((int) $id['id']) === \user()->id){
                if(CSRFToken::checkToken($request->token, false)){

                    $rules = [

                        'fullname' => ['required' => true, 'minLength' => 6, 'maxLength' => 50, 'string'=>true],
                        'address' => ['required' => true, 'minLength' => 4, 'maxLength' => 500, 'mixed' => true],
                        'country' => ['required' => true, 'minLength' => 4, 'maxLength' => 50, 'string' => true],
                        'state' => ['required' => true, 'minLength' => 3, 'maxLength' => 50, 'string' => true],
                        'phone' => ['required' => true, 'minLength' => 4, 'maxLength' => 15, 'number' => true],
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
                        }elseif (UploadFile::fileSize($file->size)){
                            $fileError['fileImage'] = ['Please select an image of your Certificate < 500kb'];
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

                        $tmpFile = $file->upload->tmp_name;
                        $optimideTo = "images" .DS. 'optimiseImages'. DS . "uploads".DS. 'users_pics'. DS . user()->username;
                        $folder = 'images'. DS . 'uploads'. DS . 'users'. DS . user()->username. DS . 'profile_pic';

                        //CREATE IMAGE PATH
                        $imagePath = UploadFile::move($tmpFile, $folder, $optimideTo, $filename, 'profile_pic')->optimisedPath();

                    }

                    if ($validate->hasError() || count($fileError)){

                        $response = $validate->getErrorMessages();
                        count($fileError)? $errors = array_merge($response, $fileError) : $errors = $response;

                        if (count($errors)){
                            $users = $this->users;
                            return view('/user/products/editUser', ['user'=>$users, 'errors'=>$errors]);
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
                                'image_path' => $imagePath
                            ]
                        );

                    if ($user){

                        Session::flash('success', 'User details has been updated successfully');
//                        $user = $this->users;
                        Redirect::to('/user/userDetails');
                    }

                }
            }



        }

        return null;

    }



    public function changePassword($id){
        if(Request::exist('post')){
            $request = Request::get('post');

//            pnd($request);
            if((int)$id['id'] === \user()->id){
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

                        $user = $this->users;
                        return view('/user/products/editUser', compact('user', 'errors' ));
                    }


                    $user = User::select('password')->where([['role', 'user'], ['id', $id]])->orWhere([['role', 'vendor'], ['id', $id]])->get();

                    if($request->new_password === $request->confirm_password){

                        foreach ($user as $password){
                            if (password_verify($request->old_password, $password->password)){

                                $newPassword = password_hash($request->new_password, PASSWORD_BCRYPT);
                                $user = User::where([['role', 'user'], ['id', $id]])->orWhere([['role', 'vendor'], ['id', $id]])->update(['password' => $newPassword]);

                                if ($user){

                                    Session::flash('success', 'Your password has been changed successfully');
                                    Redirect::to('/user/userDetails');

                                }

                            }else{

                                Session::flash('error', 'Please Enter a valid old password');
                                $user = $this->users;
                                return view('/user/products/editUser', compact('user'));

                            }


                        }

                    }

                    Session::flash('error', 'Please make sure your confirm password matches your new password');
                    $user = $this->users;
                    return view('/user/products/editUser', compact('user'));
                }
            }



        }

        return null;
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


}

?>