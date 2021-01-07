<?php
/**
 * Created by PhpStorm.
 * User: Gravity
 * Date: 20/07/2018
 * Time: 4:35 PM
 */

namespace App\Controllers;



use App\classes\Cookie;
use App\Classes\CSRFToken;
use App\Classes\Mail;
use App\classes\MailingWithGun;
use App\Classes\Redirect;
use App\classes\Request;
use App\Classes\Session;
use App\classes\ValidateRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\models\UserSession;
use App\models\VendorDetail;

class AuthController extends BaseController
{
    public $categories;

    public function __construct()
    {
        $this->categories = Category::all();
    }

    public function userAuthenticated()
    {

        if(isAuthenticated()){
            Redirect::to('/');
        }
    }


    public function showRegisterForm(){
        $this->userAuthenticated();

        $categories = $this->categories;

        return view('/register', compact('categories'));
    }

    public function showVendorRegisterForm(){
        $this->userAuthenticated();

        $categories = $this->categories;

        return view('/vendorRegister', compact('categories'));
    }



    public function showLoginForm(){
        $this->userAuthenticated();

        $categories = $this->categories;

        return view('/login', compact('categories'));
    }


    public function register(){
        //CHECK IF POST REQUEST EXIST
        if(Request::exist('post')){
            $request = Request::get('post');

            //VERIFY CSRF TOKEN
            if(CSRFToken::checkToken($request->token)){
                //CREATE VALIDATION RULES
                $rules = [
                    'username' => ['required' => true, 'maxLength' => 20, 'string' => true, 'unique' => 'users'],
                    'email' => ['required' => true, 'email' => true, 'unique' => 'users'],
                    'password' => ['required' => true, 'minLength' => 6 ],
                    'fullname' => ['required' => true, 'minLength' => 6, 'maxLength' => 50],
//                    'address' => ['required' => true, 'minLength' => 4, 'maxLength' => 500, 'mixed' => true],
                    'country_name' => ['required' => true, 'minLength' => 4, 'maxLength' => 50, 'string' => true],
//                    'region_name' => ['required' => true, 'minLength' => 3, 'maxLength' => 50, 'string' => true],
//                    'phone' => ['required' => true, 'minLength' => 4, 'maxLength' => 15, 'number' => true],

                ];

                $validate = new ValidateRequest;
                $validate->abide($_POST, $rules);

                if ($validate->hasError()){
                    $errors = $validate->getErrorMessages();

                    return view('/register', compact('errors'));
                }

                $vkey = AuthController::emailVerification($request);

                //INSERT INTO DB
                User::create([
                    'username' => $request->username,
                    'email' => $request->email,
                    'password' => password_hash($request->password, PASSWORD_BCRYPT),
                    'fullname' => $request->fullname,
//                    'city' => $request->city,
                    'country_name' => $request->country_name,
//                    'state_name' => $request->state_name,
//                    'phone' => $request->phone,
                    'role' => 'user',
                    'vkey' => $vkey,

                ]);


                //SEND VERIFICATION EMAIL
                $details = [
                    'verificationLink' => getenv('APP_URL_LOCALHOST')."/account-verification/user-$vkey",
                    'unsubscribeLink' => getenv('APP_URL_LOCALHOST')."/mailing_list-unsubscribe/user-$vkey",
                ];

                $dataVerify = [

                    'to'    => $request->email,
                    'subject'=> 'Verification Email',
                    'view'  => 'verification',
                    'body'  => $details

                ];

               AuthController::sendVerificationEmail($dataVerify);

                Request::refresh();
                Session::flash('success','Account created successfully!. An Email Verification has been sent to your Email' );
                Redirect::to('/login');

            }else{
                $env = getenv('APP_ENV');
                if ($env !== 'production'){
                    throw new \Exception('Token mismatch');
                }

            }
        }
        return null;
    }


    public function registerVendor(){
        //CHECK IF POST REQUEST EXIST
        if(Request::exist('post')){
            $request = Request::get('post');

//pnd($request);

            //VERIFY CSRF TOKEN
            if(CSRFToken::checkToken($request->token)){
                //CREATE VALIDATION RULES
                $rules = [
                    'username' => ['required' => true, 'maxLength' => 20, 'string' => true, 'unique' => 'users'],
                    'brandname' => ['required' => true, 'maxLength' => 20, 'mixed' => true, 'unique' => 'users'],
                    'email' => ['required' => true, 'email' => true, 'unique' => 'users'],
                    'password' => ['required' => true, 'minLength' => 6 ],
                    'fullname' => ['required' => true, 'minLength' => 6, 'maxLength' => 50],
//                    'address' => ['required' => true, 'minLength' => 4, 'maxLength' => 500, 'mixed' => true],
                    'country_name' => ['required' => true, 'minLength' => 4, 'maxLength' => 50, 'string' => true],
//                    'region_name' => ['required' => true, 'minLength' => 3, 'maxLength' => 50, 'string' => true],
//                    'phone' => ['required' => true, 'minLength' => 4, 'maxLength' => 15, 'number' => true],

                ];

                $validate = new ValidateRequest;
                $validate->abide($_POST, $rules);

                if ($validate->hasError()){
                    $errors = $validate->getErrorMessages();

                    return view('/vendorRegister', compact('errors'));
                }

                $vkey = AuthController::emailVerification($request);

                //INSERT INTO DB
                User::create([
                    'username' => $request->username,
                    'email' => $request->email,
                    'password' => password_hash($request->password, PASSWORD_BCRYPT),
                    'fullname' => $request->fullname,
                    'city' => $request->city,
                    'country_name' => $request->country_name,
                    'state_name' => $request->state_name,
                    'phone' => $request->phone,
                    'role' => 'vendor',
                    'vkey' => $vkey
                ]);


                //SEND VERIFICATION EMAIL
                //SEND VERIFICATION EMAIL
                $details = [
                    'verificationLink' => getenv('APP_URL_LOCALHOST')."/account-verification/vendor-$vkey",
                    'unsubscribeLink' => getenv('APP_URL_LOCALHOST')."/mailing_list-unsubscribe/vendor-$vkey",
                ];

                $dataVerify = [

                    'to'    => $request->email,
                    'subject'=> 'Verification Email',
                    'view'  => 'verification',
                    'body'  => $details

                ];

                AuthController::sendVerificationEmail($dataVerify);



                //CHECK IF USER ID EXIST
                $user = User::where('username', $request->username)->first();

                VendorDetail::create([
                    'brand_name' => $request->username,
                    'user_id' => $user->id
                ]);




                Request::refresh();
                Session::flash('success','Account created successfully!. An Email Verification has been sent to your Email' );
                Redirect::to('/login');
            }else{
                $env = getenv('APP_ENV');
                if ($env !== 'production'){
                    throw new \Exception('Token mismatch');
                }

            }
        }
        return null;
    }


    public function login(){
//CHECK IF POST REQUEST EXIST
        if(Request::exist('post')){
            $request = Request::get('post');

            //VERIFY CSRF TOKEN
            if(CSRFToken::checkToken($request->token, false)){
                //CREATE VALIDATION RULES
                $rules = [
                    'username' => ['required' => true],
                    'password' => ['required' => true ],
                    'remember_me' => ['string' => true, 'minLength' => 2, 'maxLength'=>3]

                ];

                $validate = new ValidateRequest;
                $validate->abide($_POST, $rules);

                if ($validate->hasError()){
                    $errors = $validate->getErrorMessages();

                    return view('/login', compact('errors'));
                }

                //CHECK IF USER EXIST IN THE DB
                $user = User::where('username', $request->username)->orWhere('email', $request->username)->first();
                $categories = $this->categories;

                if($user){
                    if (!password_verify($request->password, $user->password)){
                        Session::flash('error', 'Username or Password is incorrect');


                        return view('/login',  ['categories' => $categories]);
                    }elseif ($user->verified === null){
                        Session::flash('error', 'Email verification link has been sent. Please verify your account to login');


                        return view('/login',  ['categories' => $categories]);
                    } else{

                        //REMEMBER ME LOGIN INFORMATION
                        $this->remember($request->remember_me, $user->id);

                        Session::set('SESSION_USER_ID', $user->id);
                        Session::set('SESSION_USER_NAME', $user->username);

                        //CHECK ROLE OF USER AND REDIRECT TO APPROPRIATE PAGE
                        if($user->role == 'admin'){
                            Redirect::to('/admin');
                        }else if($user->role == 'user' && Session::exist('user_cart')){
                            Redirect::to('/cart');
                        }else if($user->role == 'user' && !Session::exist('user_cart')){
                            Redirect::to('/');
                        }else if($user->role == 'vendor'){
                            Redirect::to('/vendor');
                        }


                    }
                }else{
                    Session::flash('error', 'Username or Password is incorrect');
                    return view('/login', ['categories' => $categories]);
                }


//               refresh();
//                $categories = Category::all();
//                return view('/register', ['success' => 'Account created successfully!. Please login', 'categories' => $categories]);

            }else{
                $env = getenv('APP_ENV');
                if ($env == 'local'){
                    throw new \Exception('Token mismatch');
                }

            }
        }
        return null;
    }




    public function verifyAccount($key){
        //GET VERIFICATION KEY AND USER ROLE
        list($role, $vkey) = explode('-',$key['key']);

        //GET WELCOME PAGE TO EMAIL USER
        if ($role === 'user'){
            $welcomePage = 'welcome';
        }elseif($role === 'vendor'){
            $welcomePage = 'welcomeVendor';
        }else{
            return false;
        }

        $user = User::where('vkey', $vkey)->first();

        if($user){

            if (!$user->verified ) {
                //CHECK IF VERIFICATION LINKS & CODE EXIST IN THE USER DB
                $user->update(['verified' => 1]);

                Session::set('SESSION_USER_ID', $user->id);
                Session::set('SESSION_USER_NAME', $user->username);


                $details = [
                    'username' => user()->username,
                    'fullname' => \user()->fullname,
                ];

                //SEND WELCOME EMAIL TO USER
                $data = [

                    'to'    => \user()->email,
                    'subject'=> 'Welcome '.\user()->username,
                    'view'  => $welcomePage,
                    'cc'  => getenv('ADMIN_EMAIL'),
                    'ccName'  => 'noreply',
                    'name'  => 'Admin',
                    'body'  => $details

                ];

                $mailListData = [
                    'to'    => \user()->email,
                    'fullname' => \user()->fullname
                ];

                //SEND WELCOME EMAIL PAGE
                AuthController::sendVerificationEmail($data);

                //SUBSCRIBE USER TO MAILING LIST IF NOT SUBSCRIBED
                if (!$user->mailing_list){
                    AuthController::subscribeToMailList($mailListData, $role);
                    $user->update(['mailing_list' => 1]);
                }


                //CHECK ROLE OF USER AND REDIRECT TO APPROPRIATE PAGE
                if($user->role == 'admin'){
                    Redirect::to('/admin');
                }else if($user->role == 'user' && Session::exist('user_cart')){
                    Redirect::to('/cart');
                }else if($user->role == 'user' && !Session::exist('user_cart')){
                    Redirect::to('/');
                }else if($user->role == 'vendor'){
                    Redirect::to('/vendor');
                }
            }else{

                Session::flash('error', 'Account already verified, please login');
                Redirect::to('/login');
            }

        }else{
            Session::flash('error', 'Email Verification failed, please try again later');
            Redirect::to('/login');
        }


    }


    public function unsubscribe($key){

        //GET VERIFICATION KEY AND USER ROLE
        list($role, $vkey) = explode('-',$key['key']);

        //GET WELCOME PAGE TO EMAIL USER
        if ($role === 'user'){
            $welcomePage = 'welcome';
        }elseif($role === 'vendor'){
            $welcomePage = 'welcomeVendor';
        }else{
            return false;
        }


        $user = User::where([['vkey', $vkey], ['mailing_list', 1], ['role', $role]])->first();

       if ($user->mailing_list){
           AuthController::unsubscribeToMailList($user->email, $role);
           $user->update(['mailing_list' => 0]);

           Session::flash('success', 'You have successfully unsubscribed to Artisao Mailing List');
           Redirect::to("/$role");
       }



    }


    public function logout(){

        if(isAuthenticated()){
            Session::delete('SESSION_USER_ID');
            Session::delete('SESSION_USER_NAME');

            if (Cookie::exist(getenv('COOKIE_NAME'))){
                Cookie::deleteCookie(getenv('COOKIE_NAME'));
            }

            if (!Session::exist('user_cart')){
                session_destroy();
                session_regenerate_id(true);
            }
        }

        Redirect::to('/');
    }

    public function remember($remember = null, $userId){
        if ($remember === 'on'){
            $cookieName = getenv('COOKIE_NAME');
            $rememberMeID  = md5(random_bytes(128) );
            $rememberMeHash = md5( random_bytes(128));
            $uagent = Session::uagentNoVersion();
//pnd($rememberMeHash);
            //GET USER ID AND CHECK IF COOKIE ALREADY EXIST
            $oldSession = UserSession::where('user_id', $userId)->first();


            //SET COOKIE
            Cookie::setCookie($cookieName, $rememberMeHash, getenv('COOKIE_EXPIRY'));

            if ($oldSession){
                UserSession::updateOrCreate(
                    ['user_id' => $userId, 'user_agent' => $oldSession->user_agent],
                    ['cookie_id' => $rememberMeID, 'cookie_hash' => $rememberMeHash , 'user_agent' => $uagent]
                );

            }else{
                UserSession::updateOrCreate(
                    ['user_id' => $userId],
                    ['cookie_id' => $rememberMeID, 'cookie_hash' => $rememberMeHash , 'user_agent' => $uagent]
                );

            }

        }
        return false;
    }


    public static function loginWithCookie(){
        $cookie = Cookie::getCookie(getenv('COOKIE_NAME'));
        $uagent = Session::uagentNoVersion();
        $userSession = UserSession::where([['cookie_hash', $cookie], ['user_agent', $uagent]])->with('user')->first();
//pnd($userSession);
        if ($userSession){
            //GET USER CREDENTIALS AND LOGIN
            $userId = $userSession->user->id;
            $userName = $userSession->user->username;

            Session::set('SESSION_USER_ID', $userId);
            Session::set('SESSION_USER_NAME', $userName);

            //CHECK ROLE OF USER AND REDIRECT TO APPROPRIATE PAGE
            if($userSession->user->role == 'admin'){
                Redirect::to('/admin');
            }else if($userSession->user->role == 'user' && Session::exist('user_cart')){
                Redirect::to('/cart');
            }else if($userSession->user->role == 'user' && !Session::exist('user_cart')){
                Redirect::to('/');
            }else if($userSession->user->role == 'vendor'){
                Redirect::to('/vendor');
            }


        }else{
            return false;
        }
        return false;
    }



    public static function emailVerification($request){
        $vkey = md5(time().$request->username);
        return $vkey;
    }


    public static function sendVerificationEmail($data){
        $mail = new MailingWithGun;
        $mail->send($data);
        return new static;
    }


    public static function subscribeToMailList($data, $role){

        $mailgun = new MailingWithGun;
        $mailgun->mailList($data, $role);
        return new static;

    }

    public static function unsubscribeToMailList($email, $role){

        $mailgun = new MailingWithGun;
        $mailgun->unsubscribeMailList($email, $role);
        return new static;

    }




}






?>