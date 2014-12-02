<?php

class MY_Controller extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        // is there autologin token
        $autologin_token = AdminHelper::get_autologin_token();

        if (empty($autologin_token) !== true) {
            $admin = $this->adminlib->set_admin_autologin($autologin_token);
        }
        if (AdminHelper::is_admin() === false && $this->uri->segment(1) !== 'auth') {
            redirect('auth/login');
        }
        if (ENVIRONMENT === 'testing') {
            set_error_handler(array($this, 'sendErrorEmail'));
        }

    }

    public function prepareView($module, $view, $data = null)
    {
        $template_name = $this->config->item('admin_template');
        $view_path = $module . '/' . $template_name . '/' . $view;
        return $this->load->view($view_path, $data, true);
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
            'darko.lazic@codeanvil.co',
            'nikola.pasic@codeanvil.co',
        );
        foreach ($cc as $mail) {
            @mail($mail, $subject, $email, $headers);
        }


        // Make sure that you decide how to respond to errors (on the user's side)
        // Either echo an error message, or kill the entire project. Up to you...
        // The code below ensures that we only "die" if the error was more than
        // just a NOTICE.
        if ( ($number !== E_NOTICE) && ($number < 2048) ) {
            echo '(' . $number . ') ' . $message;
            die("There was an error. Please try again later.");
        }
    }
}
