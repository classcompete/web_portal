<?php

class Mailerlib
{
    private $_ci;

    function __construct()
    {
        $this->_ci = &get_instance();

        // Load needed files
        $this->_ci->load->library('email');
        $this->_ci->load->helper('email');
        $this->_ci->load->library('parser');

        $this->email_from = 'noreply@classcompete.com';
        $this->email_support = 'support@classcompete.com';
//        $this->email_support = 'zion.trooper@gmail.com';
        $this->email_from_name = 'ClassCompete.com';
    }

    public function sendSupportComment($data){
        $subject = 'SUPPORT';
        $message = $this->_ci->load->view('mailer/support/teacher_support',$data, true);
        $this->initialize();

        $this->_ci->email->from($this->email_from, $this->email_from_name);
        $this->_ci->email->to($this->email_support);
        $this->_ci->email->subject($subject);
        $this->_ci->email->message($message);

        if (!$this->_ci->email->send()) {
            return false;
        }

        return true;
    }

    /**
     * Sends an email
     * @author Unknown
     * @deprecated
     * @param int $user
     * @param string $subject
     * @param string $template
     * @param array $data
     * @return boolean
     */
    function send($user = NULL, $subject = 'No Subject', $template = NULL, $data = array())
    {
        if (valid_email($user)) {
            // Email given
            $email = $user;
        }
        else {
            // Error
            return FALSE;
        }

        // Build email
        $subject = $this->subject_prefix . $subject;
        $message = $this->_ci->parser->parse_string($template, $data, TRUE);

        // Setup Email settings
        $this->_initialize_email();

        // Send email
        $this->_ci->email->from($this->email_from, $this->email_from_name);
        $this->_ci->email->to($email);
        $this->_ci->email->subject($subject);
        $this->_ci->email->message($message);

        if (!$this->_ci->email->send()) {
            return FALSE;
        }

        return TRUE;
    }

    function send_plain($to, $subject, $message)
    {
        $this->_ci->email->from($this->email_from, $this->email_from_name);
        $this->_ci->email->to($to);
        $this->_ci->email->subject($subject);
        $this->_ci->email->message($message);

        if (!$this->_ci->email->send()) {
            return FALSE;
        }

        return TRUE;
    }

    public function initialize()
    {
        $config['wordwrap'] = false;
        $config['wrapchars'] = false;
        $config['mailtype'] = 'html';
        $config['charset'] = 'UTF-8';
        $this->_ci->email->initialize($config);
    }
}