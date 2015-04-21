<?php

class Gradelib {

    private $ci;

    public function __construct(){
        $this->ci = & get_instance();
        $this->ci->load->model('x_grade/grade_model');
        //$this->ci->load->helper('x_grade/grade');
    }
}