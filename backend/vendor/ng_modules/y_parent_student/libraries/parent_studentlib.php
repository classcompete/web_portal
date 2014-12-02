<?php
class Parent_studentlib{

    private $ci;

    public function __construct(){
        $this->ci = &get_instance();
        $this->ci->load->model('y_parent_student/parent_student_model');
        $this->ci->load->helper('y_parent_student/parent_student');
    }
}