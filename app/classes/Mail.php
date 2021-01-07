<?php
/**
 * Created by PhpStorm.
 * User: Gravity
 * Date: 25/07/2018
 * Time: 3:35 PM
 */

namespace App\Classes;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
class Mail
{

    protected $_mail;

    public function __construct()
    {
        $this->_mail = new PHPMailer;
        $this->setUp();
    }

    public function setUp(){

        $this->_mail->isSMTP();
        $this->_mail->Mailer = 'smtp';
        $this->_mail->SMTPAuth = true;
        $this->_mail->SMTPSecure = 'tls';

        //HOST AND PORT
        $this->_mail->Host = getenv('SMTP_HOST');
        $this->_mail->Port = getenv('SMTP_PORT');

        //ADD CUSTOM HEADERS


        //DEBUG
        $env = getenv('APP_ENV');
        if ($env !== 'production'){
            $this->_mail->SMTPDebug = '';
        }else{
            $this->_mail->SMTPDebug = '';
        }

        //AUTHENTICATION INFO
        $this->_mail->Username = getenv('EMAIL_USERNAME');
        $this->_mail->Password = getenv('EMAIL_PASSWORD');

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
        $this->_mail->addCC($data['cc'], $data['ccName']);
        $this->_mail->Body = make($data['view'], ['data' => $data['body']]);

        try{

            return $this->_mail->send();
        }catch (Exception $e){
            return 'Message: '.$e->getMessage();
        }

    }


}


?>