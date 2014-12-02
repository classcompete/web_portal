<?php
/**
 * Created by PhpStorm.
 * User: FenjeR
 * Date: 11/12/13
 * Time: 1:54 PM
 */
class Schoollib{
    private $ci;

    public function __construct(){
        $this->ci = &get_instance();
        $this->ci->load->model('y_school/school_model');
        $this->ci->load->helper('y_school/school');
    }
}