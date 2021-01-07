<?php
/**
 * Created by PhpStorm.
 * User: Gravity
 * Date: 20/07/2018
 * Time: 4:35 PM
 */

namespace App\Controllers;



use App\classes\Cart;
use App\Classes\CSRFToken;
use App\classes\Hubtel;
use App\Classes\Mail;
use App\Classes\Redirect;
use App\classes\Request;
use App\classes\Role;
use App\Classes\Session;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Payment;
use App\Models\Product;
use GuzzleHttp\Client;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;


class CartController extends BaseController
{
    private $_getPaypalApproval;

    public function __construct()
    {
        if (!Role::middleware('admin')){
            Redirect::to('/login');
        }

//        $this->_getPaypalApproval = $this->getPaypalApproval();

    }

    public function show(){
        $categories = Category::all();
        if (user()){
            return view('cart', compact('categories'));
        }
        return view('cart_no_checkout', compact('categories'));
    }

    public function getCartItems(){
//        dnd($_SESSION['user_cart']);
        try{
            $result = array();
            $checkoutItems = [];
            $cartTotal = 0;

            //CHECK IF THE IS SESSION FOR CART ITEMS AND IF IT IS NOT EMPTY
            if(!Session::exist('user_cart') || count(Session::get('user_cart')) < 1){
                echo json_encode(['failed' => 'No item in Cart']); exit();
            }

            $index = 0;
            //LOOP
            foreach ($_SESSION['user_cart'] as $cart_items) {
                $product_id = $cart_items['product_id'];
                $quantity = $cart_items['quantity'];

                //GET PRODUCT FROM DATABASE WITH THAT ID AND SHOW IN CART
                $item = Product::where('id', $product_id)->first();

                //SKIP ITEM IF NOT FOUND IN THE CART OR DB BUT STORED IN THE $_SESSION
                if(!$item){continue;}

                $totalPrice = $item->price * $quantity;
                $cartTotal = $totalPrice + $cartTotal;
                $totalPrice = number_format($totalPrice, 2);

                array_push($result, [
                    'id' => $item->id,
                    'name' => $item->name,
                    'image' => $item->image_path,
                    'description' => $item->description,
                    'price' => $totalPrice,
                    'unitPrice' => $item->price,
                    'total' => $totalPrice,
                    'quantity' => $quantity, //THIS REFERS TO THE CART ITEM QUANTITY
                    'stock' => $item->quantity, // THIS REFERS TO THE DB ITEM QUANTITY
                    'newStock' => $item->quantity - $quantity,
                    'index' => $index
                ]);


                $index ++;

            }

            $cartTotal = number_format($cartTotal, 2);
            echo json_encode(['items' => $result, 'cartTotal' => $cartTotal, 'authenticated' => isAuthenticated()]); exit();

        }catch (\Exception $exception){
            //LOG THIS IN THE DATABASE OR EMAIL ADMIN
        }
    }

    public function addItem(){

        if(Request::exist('post')){
            $request = Request::get('post');
            if(CSRFToken::checkToken($request->token, false)){
                if(!$request->product_id){
                    throw new \Exception('Malicious Activity');
                }
                Cart::add($request);
                echo json_encode(['success' => 'product added to cart successfully']); exit();
            }
        }

    }

    public function updateQuantity(){
        if(Request::exist('post')){
            $request = Request::get('post');

            if (!$request->product_id) {
                    throw new \Exception('Malicious Activity');
            }

            $index = 0;
            $quantity = '';

            foreach ($_SESSION['user_cart'] as $cart_items) {
                $index++;
                foreach ($cart_items as $key => $value) {
                    if($key == 'product_id' && $value == $request->product_id){
                        switch ($request->operator){
                            case '+':
                                $quantity = $cart_items['quantity'] + 1;
                                break;

                            case '-':
                                $quantity = $cart_items['quantity'] - 1;
                                if ($quantity < 1){
                                    $quantity = 1;
                                }
                                break;
                        }

                        array_splice($_SESSION['user_cart'], $index-1, 1, [
                            [
                                'product_id' => $request->product_id,
                                'quantity' => $quantity
                            ]
                        ]);

                    }
                }
            }

        }
    }


    public function removeItem(){
        if(Request::exist('post')) {
            $request = Request::get('post');

            if ($request->item_index === ''){
                throw new \Exception('Malicious activity detected');
            }

            //REMOVE ITEM
            Cart::removeItem($request->item_index);
            echo json_encode(['success' => 'Product Removed from cart']); exit();
        }

    }

    public function emptyCart(){

        if(Session::exist('user_cart')){

            Cart::clear();
            echo json_encode(['success' => 'All cart items removed']); exit();
        }


    }


    public function payWithMM(){
        if (Request::exist('post')){
            $request = Request::get('post');

            if (CSRFToken::checkToken($request->token)){

                $itemsArray = [];
                $itemKeys = ['name', 'quantity', 'unitPrice'];

                $index = 0;

                foreach ($request->items as $item) {

                    foreach ($item as $key => $val) {
                        if (in_array($key, $itemKeys)){
                            $itemsArray[$index][$key] = $val;
                        }

                    }
//

                    $index++;
                }

                $invoice =  array (
                    'items' => $itemsArray,
                    'totalAmount' => $request->cartTotal,
                    'description' => 'Artisao Store',
                    'callbackUrl' => 'http://artisao.local/cart',
//                    'callbackUrl' => 'https://webhook.site',
                    'returnUrl' => 'http://artisao.local',
                    'merchantBusinessLogoUrl' => 'http://artisao.local/images/logo.png',
                    'merchantAccountNumber' => getenv('MERCHANT_ACCOUNT_NUMBER'),
                    'cancellationUrl' => 'http://artisao.local',
                    'clientReference' => 'inv'.mt_rand(1000000, 9999999),
                );

                $payload = [
                    'price' => 1,
                    'network' => 'mtn',
                    'recipient_number' => '0501334632',
                    'sender' => '0245991097',
                    'option' => 'rmtm',
                    'apikey' => getenv('API_KEY')
                ];
//pnd(json_encode($payload));
                $headers = ['Content-Type: application/json'];
                $url = getenv('URL');

                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload) );
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                $output = curl_exec($ch);
                dnd($output);
                echo $output;
            }

        }
    }


    public function checkout(){

        if (Request::exist('post')){
            $request = Request::get('post');

            if (CSRFToken::checkToken($request->token)){

                $itemsArray = [];
                $itemKeys = ['name', 'quantity', 'unitPrice'];

                $index = 0;

                foreach ($request->items as $item) {

                    foreach ($item as $key => $val) {
                        if (in_array($key, $itemKeys)){
                            $itemsArray[$index][$key] = $val;
                        }

                   }
//

                    $index++;
                }

//pnd($request->cartTotal);

                $invoice =  array (
                    'items' => $itemsArray,
                    'totalAmount' => $request->cartTotal,
                    'description' => 'Artisao Store',
                    'callbackUrl' => 'http://artisao.local/cart',
//                    'callbackUrl' => 'https://webhook.site',
                    'returnUrl' => 'http://artisao.local',
                    'merchantBusinessLogoUrl' => 'http://artisao.local/images/logo.png',
                    'merchantAccountNumber' => getenv('MERCHANT_ACCOUNT_NUMBER'),
                    'cancellationUrl' => 'http://artisao.local',
                    'clientReference' => 'inv'.mt_rand(1000000, 9999999),
                );


               $hubtel = new Hubtel;
                $response = $hubtel->payment($invoice);

                echo $response;
            }

        }


    }

    public function mobileMoney(){
        if (Request::exist('post')) {
            $request = Request::get('post');

            $data = [
                'CustomerName' => 'fred',
                'CustomerMsisdn' => '0245991097',
                'CustomerEmail' => 'babispyro07@gmai.com',
                'Channel' => 'mtn-gh',
                'Amount' => '1.0',
                'PrimaryCallbaackUrl' => 'http://artisao.local/cart/mobilemoney',
                'Description' => 'Test'
            ];

            $url = 'https://api.hubtel.com/v1/merchantaccount/merchants/'. getenv('MERCHANT_ACCOUNT_NUMBER').'/receive/mobilemoney';

            $opt = [
                'http' => [
                            'method' => 'POST',
                            'header' => "Content-Type: application/json\r\n" .
                                        "Accept: application/json\r\n" .
                                        "Authorization: Basic ". base64_encode(getenv('CLIENT_ID') . ':' . getenv('CLIENT_SECRET')) ."\r\n",
                            'content' => json_encode($data)
                        ]
            ];


            $context = stream_context_create($opt);
            $result = file_get_contents($url, false, $context);
            dnd($result);
        }

    }

    public function paypalCreatePayment(){
        //CREATE A PAYMENT AND POST TO PAYPAL API
        $client = new Client;

        if(getenv('APP_ENV') !== 'production'){
            $paypalBaseUrl = 'https://api.sandbox.paypal.com/v1';
        }else{
            $paypalBaseUrl = 'https://api.sandbox.paypal.com/v1/payments/payment';
        }


        $accessTokenRequest = $client->post("{$paypalBaseUrl}/oauth2/token", [
            'headers'=> ['Accept' => 'application/json'],
            'auth' => [getenv('PAYPAL_CLIENT_ID'), getenv("PAYPAL_SECRET")],
            'form-params' => ['grant_type' => 'client_credentials']
        ]);

        pnd ($accessTokenRequest);
        $token = json_decode($accessTokenRequest->getBody());

        $bearerToken = $token->access_token;

    }


    public function paypalExecutePayment(){

    }


    private function itemizeCart(){
        if(Request::exist('post')){
            $request = Request::get('post');

            if(CSRFToken::checkToken($request->token, false)){

                $itemsArray = [];
                $itemKeys = ['name', 'quantity', 'unitPrice', 'id', 'total', 'newStock'];

                $index = 0;

                foreach ($request->items as $item) {

                    foreach ($item as $key => $val) {
                        if (in_array($key, $itemKeys)){
                            $itemsArray[$index][$key] = $val;
                        }

                    }
//

                    $index++;
                }

                $subTotal = $request->cartTotal;
//pnd($itemsArray);
                return $itemsArray;


            }

        }
        return null;
    }


    private function getSubtotal(){
        if (Request::exist('post')){
            $request = Request::get('post');
            if (CSRFToken::checkToken($request->token)){

                return $request->cartTotal;
            }
        }
        return null;
    }

    private function getPaypalApproval(){
        //SET PAYPAY SDK AUTHORISATION HERE
        if(getenv('APP_ENV') !== 'production'){
            $paypal = new \PayPal\Rest\ApiContext(
                new \PayPal\Auth\OAuthTokenCredential(getenv('PAYPAL_CLIENT_ID'), getenv('PAYPAL_SECRET'))
            );
        }else{
            $paypal = new \PayPal\Rest\ApiContext(
                new \PayPal\Auth\OAuthTokenCredential(getenv('LIVE_PAYPAL_CLIENT_ID'), getenv('LIVE_PAYPAL_SECRET'))
            );
        }


        return $paypal;

    }

    public function paypalSDK(){

        //IF URL IS LOCAL OR LIVE BASED ON APP ENVIRONMENT
        if (getenv('APP_ENV') !== 'production'){
            $baseUrl = getenv('APP_URL_LOCALHOST');
        }else{
            $baseUrl = getenv('APP_URL');
        }


        $payer = new Payer;
        $payer->setPaymentMethod('paypal');


        $itemListArray = [];

        foreach ($this->itemizeCart() as $itemize) {
            $item = new Item;

            $item->setName($itemize['name'])
                ->setCurrency('USD')
                ->setQuantity($itemize['quantity'])
                ->setSku(mt_rand(1000000, 9999999))
                ->setPrice($itemize['unitPrice']);

            array_push($itemListArray, $item);

            OrderDetail::create([
                'user_id' => user()->id,
                'product_id' => $itemize['id'],
                'unit_price' => $itemize['unitPrice'],
                'quantity' => $itemize['quantity'],
                'total' => $itemize['total'],
                'status' => 'pending',
                'order_no' => strtoupper(uniqid())
            ]);


            Product::where('id',$itemize['id'] )->update(['quantity' =>$itemize['newStock'] ]);


        }
//pnd($itemListArray);



        $subTotal = $this->getSubtotal();
        $shipping = 0;
        $tax = 0;
        $totalAmt = $shipping + $tax + $subTotal;

        $itemList = new ItemList;
        $itemList->setItems($itemListArray);

        $details = new Details;
        $details->setShipping($shipping)->setTax($tax)->setSubtotal($subTotal);

        $amount = new Amount;
        $amount->setCurrency('USD')->setTotal($totalAmt)->setDetails($details);

        $transaction = new Transaction;
        $transaction->setAmount($amount)->setItemList($itemList)->setDescription('Artisao Store')->setInvoiceNumber(uniqid());


//pnd($baseUrl);
        $redirectUrl = new RedirectUrls;
        $redirectUrl->setReturnUrl("$baseUrl/cart/paypalAPI/success/")->setCancelUrl("$baseUrl/cart/paypalAPI/failed/");

        $payment = new \PayPal\Api\Payment();
        $payment->setIntent('sale')->setPayer($payer)->setRedirectUrls($redirectUrl)->setTransactions(array($transaction));


        try{
            $payment->create($this->_getPaypalApproval);
        }catch (\Exception $e){
            echo $e->getMessage();
        }

        $approvalUrl = $payment->getApprovalLink();

        //REDIRECT TO PAYPAL
        echo json_encode(['paypalUrl' => $approvalUrl]);


    }

    public function paypalSDKStatus(){
        if (Request::exist('get')){
            $request = Request::get('get');
            $categories = Category::all();

            $url = $_SERVER['REQUEST_URI'];
            $parsed = parse_url($url);
            $query = $parsed['query'];
            $urlPath = $parsed['path'];

            if(isset($_SERVER['REQUEST_URI']) && $urlPath === '/cart/paypalAPI/success/' && $request->paymentId){
                $paymentID = $request->paymentId;
                $token = $request->token;
                $payerID = $request->PayerID;

                $payment = \PayPal\Api\Payment::get($paymentID, $this->_getPaypalApproval);
                $execution = new PaymentExecution;
                $execution->setPayerId($payerID);

                try{

                    $result = $payment->execute($execution, $this->_getPaypalApproval); pnd($result);

                }catch (\Exception $e){
                    if (getenv('APP_ENV') !== 'production'){
                        die($e->getMessage());
                    }else{
                        //SEND ADMIN AN EMAIL
                        Session::flash('error',':( OOOPS!, Something went wrong please try again later.');
                        return view('/cart', compact('categories'));
//                        Redirect::to(getenv('APP_URL'.'/cart'));
                    }
                }

                if ($result){
                    $resultAry = [];

                    $orderDetails = OrderDetail::where('user_id', user()->id)->get();
                    $orderNo = $orderDetails->order_no;
                    $orderAmt = count($orderDetails->price);
pnd($orderNo);

                    //CHARGE CUSTOMER WITH PAYMENT
                    Payment::create([
                        'user_id' => user()->id,
                        'order_no' => $orderNo,
                        'amount' => $orderAmt,
                        'status' => 'completed'

                    ]);

                    OrderDetail::where('user_id', user()->id )->update(['status' => 'completed']);

                    $resultAry['order_no'] = $orderNo;
                    $resultAry['total'] = $orderAmt;

                    //DATA FOR SENDING IMAGE
                    $data = [
                        'to' => user()->email,
                        'subject' => 'Order Confirmation',
                        'view' => 'purchase',
                        'name' => user()->fullname,
                        'body' => $resultAry
                    ];

                    (new Mail())->send($data);
pnd($data);
                    Cart::clear();
                    Session::flash('success', 'Thanks for buying from Artisao.com, GoodLuck :)');
                    return view('/cart', compact('categories'));
//                    Redirect::to(getenv('APP_URL'.'/cart'));
                }




            }else{
                Session::flash('error', ':( OOOPS!, Something went wrong please try again later.');
                $this->failed();
//                return view('/failedCart', compact('categories'));
//                header("Location:" . getenv('APP_URL'.'/'));
//                Redirect::to(getenv('APP_URL'.'/cart'));
            }


        }
        return null;
    }



    public function ipay(){
        if (Request::exist('post')){
            $request = Request::get('post');
            $channel = filter_var($request->channel, FILTER_SANITIZE_STRING);
            $phone = filter_var($request->phone, FILTER_SANITIZE_NUMBER_INT);

            if (CSRFToken::checkToken($request->token, false)){

                $itemListArray = [];
                $itemizeID = '';
                $itemizeStock = '';

                foreach ($this->itemizeCart() as $itemize) {
                    $invoice_id = strtoupper( 'inv'.mt_rand(1000000, 9999999));
                    OrderDetail::create([
                        'user_id' => user()->id,
                        'product_id' => $itemize['id'],
                        'unit_price' => $itemize['unitPrice'],
                        'quantity' => $itemize['quantity'],
                        'total' => $itemize['total'],
                        'status' => 'pending',
                        'order_id' => $invoice_id
                    ]);

                    Order::create([
                        'user_id' => user()->id,
                        'order_id' => $invoice_id
                    ]);

                    $itemizeID = $itemize['id'];
                    $itemizeStock = $itemize['newStock'];




                }

                if (user()->phone !== $phone){
                    $phoneNumber = $phone;
                }else{
                    $phoneNumber = user()->phone;
                }


                $ipayAry = [
                    'merchant_key' => urlencode( getenv('IPAY_MERCHANT_KEY')),
                    'invoice_id' => $invoice_id,
                    'total' => urlencode($request->cartTotal * getenv('GHC_RATE')),
                    'pymt_instrument' => '0'. $phoneNumber,
                    'extra_wallet_issuer_hint' => $channel,
                    'extra_name' => user()->fullname,
                    'number' => user()->phone,
                    'email' => user()->email
//                    'ipn_url' => urlencode( $appUrl.'/ipay/notice/'),
//                    'success_url' => urlencode($appUrl . '/cart'),
//                    'cancelled_url' => urlencode($appUrl . '/cart'),
//                    'currency' => urlencode('GHS')
                ];

                //POST DATA WITH CURL
                $url = getenv('IPAY_URL');
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($ipayAry));
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                $result = curl_exec($ch);
                curl_close($ch);

                $result = json_decode($result);

                if ($result->success){

                    $getUrl = 'https://community.ipaygh.com/v1/gateway/json_status_chk?invoice_id='.$invoice_id.'&merchant_key='.getenv('IPAY_MERCHANT_KEY');

                    //GET DATA FROM IPAY GHANA WITH CURL
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $getUrl);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_HTTPGET, true);

                    $result = curl_exec($ch);
                    curl_close($ch);

                    if (curl_errno($ch)){
                        echo curl_errno($ch);
                    }else{
                        $result = json_decode($result,true);
                        $orderStatus = $result[$invoice_id]['status'];
//pnd($invoice_id);
                        if ($orderStatus === 'paid'){
                            OrderDetail::where('order_id', $invoice_id)->update(['status' => 'paid']);

                            Order::create([
                                'user_id' => user()->id,
                                'order_id' => $invoice_id
                            ]);

                            Payment::create([
                                'user_id' => user()->id,
                                'amount' => $request->cartTotal,
                                'status' => 'completed',
                                'invoice_id' => $invoice_id
                            ]);

                            Product::where('id',$itemizeID )->update(['quantity' =>$itemizeStock ]);

                            Cart::clear();
                            Session::flash('success',':) Thanks for shopping with us');
                            echo json_encode(['result' => $result[$invoice_id]['status']]);
                        }

                        return null;

                    }


                }

            }else{
                die('malicious activity detected');
            }

        }else{
            die('please try again');
        }
    }


    public function ipayNotice(){

    }









}









?>