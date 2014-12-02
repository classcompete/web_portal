<?php

class SubjectLib
{
    private $ci;







    public function __construct(){
        $this->ci = & get_instance();
        $this->ci->load->model('x_subject/subject_model');
        $this->ci->load->helper('x_subject/subject');
    }
}

class Subject_Exception extends Exception
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