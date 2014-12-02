<?php
/**
 * Created by PhpStorm.
 * User: Darko
 * Date: 6/16/14
 * Time: 1:07 PM
 */
class Classlib {

    private $ci;

    public function __construct(){
        $this->ci = & get_instance();
        $this->ci->load->model('x_class/class_model');
        $this->ci->load->model('x_class/class_student_model');
        $this->ci->load->helper('x_class/class');
    }
}