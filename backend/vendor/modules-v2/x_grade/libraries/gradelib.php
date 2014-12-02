<?php
/**
 * Created by PhpStorm.
 * User: darko
 * Date: 4/7/14
 * Time: 1:21 PM
 */
class Gradelib {

    private $ci;

    public function __construct(){
        $this->ci = & get_instance();
        $this->ci->load->model('x_grade/grade_model');
        $this->ci->load->helper('x_grade/grade');
    }
}