<?php
class Parentstudentconnectionlib
{

    private $ci;

    public function __construct()
    {
        $this->ci = & get_instance();
        $this->ci->load->model('x_parent_student_connection/parent_student_connection_model');
        $this->ci->load->helper('x_parent_student_connection/parent_student_connection');
    }
}

class Parentstudentconnectionlib_Exception extends Exception
{

    public function __construct($message, $code = null, $previous = null)
    {
        if ($code === null && $previous === null) {
            parent::__construct($message);
        } elseif ($previous === null && empty($code) === false) {
            parent::__construct($message, $code);
        } else {
            parent::__construct($message, $code, $previous);
        }

    }
}