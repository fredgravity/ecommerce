<?php
/**
 * Created by PhpStorm.
 * User: gravity
 * Date: 1/30/2019
 * Time: 2:49 PM
 */

namespace App\classes;

use Mailgun\Mailgun;
use PHPMailer\PHPMailer\PHPMailer;
use Http\Adapter\Guzzle6\Client;

class MailingWithGun
{

    protected $_mailgun, $_mailgunValidate, $_mail;


    public function __construct()
    {
        $this->_mailgun =new Mailgun(getenv('MAILGUN_API_KEY'), new Client());
        $this->_mailgunValidate = new Mailgun(getenv('MAILGUN_PUBLIC_KEY'), new Client());

        $this->_mail = new PHPMailer;
        $this->setup();

    }


    public function setup(){


            $this->_mail->isSMTP();
            $this->_mail->Mailer = 'smtp';
            $this->_mail->SMTPAuth = true;
            $this->_mail->SMTPSecure = 'tls';

            //HOST AND PORT
            $this->_mail->Host = getenv('MAILGUN_SMTP');
            $this->_mail->Port = getenv('MAILGUN_SMTP_PORT');


            //DEBUG
            $env = getenv('APP_ENV');
            if ($env !== 'production'){
                $this->_mail->SMTPDebug = '';
            }else{
                $this->_mail->SMTPDebug = '';
            }

            //AUTHENTICATION INFO
            $this->_mail->Username = getenv('MAILGUN_SMTP_LOGIN');
            $this->_mail->Password = getenv('MAILGUN_PASSWORD');

            $this->_mail->isHTML(true);
            $this->_mail->SingleTo = true;

            //SENDER INFORMATION
            $this->_mail->From = getenv('ADMIN_EMAIL');
            $this->_mail->FromName = getenv('APP_NAME');



    }



    public function send($data){

        //RECIPIENT ADDRESS
        $this->_mail->addAddress($data['to'], $data['name']);
        $this->_mail->Subject = $data['subject'];
//        $this->_mail->addCC($data['cc'], $data['ccName']);
        $this->_mail->Body = make($data['view'], ['data' => $data['body']]);

        try{

            return $this->_mail->send();

        }catch (\Exception $e){
            return 'Message: '.$e->getMessage();
        }


    }



    public function sendWithApi($data){

        try{

            //SEND EMAIL WITH MAILGUN VIA SANDBOX
            return $this->_mailgun->messages()->send(getenv('MAILGUN_SANDBOX_DOMAIN'), $data);


        }catch (\Exception $e){
            return 'Message: '.$e->getMessage();

        }

    }


    public function mailList($data, $role){
        $mgClient = $this->_mailgun;

        $listAddress = '';

        if ($role === 'user'){
            $listAddress = getenv('MAILGUN_MAILING_LIST_USERS');
        }elseif ($role === 'vendor'){
            $listAddress = getenv('MAILGUN_MAILING_LIST_VENDORS');
        }


        //ADD USER TO MAILING LIST
        $result = $mgClient->post("lists/$listAddress/members", [
           'address'        => $data['to'],
            'name'          => $data['fullname'],
            'description'   => 'User Signup News',
            'subscribed'    => true
        ]);

        return $result;
    }



    public function unsubscribeMailList($email, $role){
        $mgClient = $this->_mailgun;

        $listAddress = '';

        if ($role === 'user'){
            $listAddress = getenv('MAILGUN_MAILING_LIST_USERS');
        }elseif ($role === 'vendor'){
            $listAddress = getenv('MAILGUN_MAILING_LIST_VENDORS');
        }

        $result = $mgClient->put("lists/$listAddress/members/$email", [
           'subscribed' => false
        ]);

       return $result;

    }


    public function sendToMailingList($data, $role){
        $mgClient = $this->_mailgun;

        $listAddress = '';

        if ($role === 'user'){
            $listAddress = getenv('MAILGUN_MAILING_LIST_USERS');
        }elseif ($role === 'vendor'){
            $listAddress = getenv('MAILGUN_MAILING_LIST_VENDORS');
        }
//        pnd(make($data['view'], ['data' => $data['message']]));
        $result = $mgClient->sendMessage(getenv('MAILGUN_SANDBOX_DOMAIN'), [
           'from'       => $data['from'],
           'to'         => $listAddress,
           'subject'    => $data['subject'],
           'html'       => make($data['view'], ['data' => $data['message']])

        ]);

        return $result;

    }



}








?>