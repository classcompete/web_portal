<?php

class Studentlib{

	private $ci;

    public function __construct(){
        $this->ci = &get_instance();
        $this->ci->load->model('x_users/student_model');
        $this->ci->load->model('x_users/student_import_model');
	    $this->ci->load->helper('x_users/student');
    }

    public function encodePassword($text) {
        return md5($text);
    }
}
