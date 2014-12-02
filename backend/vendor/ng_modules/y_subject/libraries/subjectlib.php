<?php

class SubjectLib
{
    private $ci;

    public function __construct(){
        $this->ci = & get_instance();
        $this->ci->load->model('y_subject/subject_model');
        $this->ci->load->helper('y_subject/subject');
    }
}