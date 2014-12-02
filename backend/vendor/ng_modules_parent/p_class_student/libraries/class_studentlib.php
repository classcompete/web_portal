<?php
/**
 * Created by PhpStorm.
 * User: FenjeR
 * Date: 12/20/13
 * Time: 1:54 PM
 */
class Class_studentlib{
    private $ci;

    public function __construct(){
        $this->ci = &get_instance();
        $this->ci->load->model('p_class_student/class_student_model');
        $this->ci->load->helper('p_class_student/class_student');
    }
}