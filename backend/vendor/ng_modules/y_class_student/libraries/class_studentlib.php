<?php
/**
 * Created by PhpStorm.
 * User: Darko Lazic
 * Date: 01/11/13
 * Time: 19:16
 */
class Class_studentlib{

    private $ci;

    public function __construct(){
        $this->ci = &get_instance();
        $this->ci->load->model('y_class_student/class_student_model');
        $this->ci->load->helper('y_class_student/class_student');
    }
}