<?php

class MY_Controller extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $method = $_SERVER['REQUEST_METHOD'];
        if($method == "OPTIONS") {
            die();
        }
        if (ParentHelper::is_parent_rest() === false && $this->uri->segment(1) !== 'login' && $this->uri->segment(1) !== 'login_social' && $this->uri->segment(1) !== 'registration' && $this->uri->segment(1) !== 'forgot_password'
            && $this->uri->segment(1) !== 'school' && $this->uri->segment(1) != 'registration_facebook' && $this->uri->segment(1) != 'registration_google' && $this->uri->segment(1) !== 'password_recovery') {
            $this->response(null,401);
            exit(0);
        }
        if (ENVIRONMENT === 'testing') {
//            set_error_handler(array($this, 'sendErrorEmail'));
        }
    }


    public function sendErrorEmail($number, $message, $file, $line, $vars)
    {
        $email = "
        <p>An error ($number) occurred on line
        <strong>$line</strong> and in the <strong>file: $file.</strong>
        <p> $message </p>";

        $email .= "<pre>" . print_r($vars, 1) . "</pre>";

        $subject = '[DOM] ClassCompete Error Handler' . "\r\n";

        $headers = '';
        $headers .= 'From: error-mailer@dev-o-matic.org' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        // Email the error to someone...
        $cc = array(
            'nemanja.cimbaljevic@codeanvil.co',
            'darko.lazic@codeanvil.co'
        );
        foreach ($cc as $mail) {
            @mail($mail, $subject, $email, $headers);
        }


        // Make sure that you decide how to respond to errors (on the user's side)
        // Either echo an error message, or kill the entire project. Up to you...
        // The code below ensures that we only "die" if the error was more than
        // just a NOTICE.
        if ( ($number !== E_NOTICE) && ($number < 2048) ) {
            die("There was an error. Please try again later.");
        }
    }
}
