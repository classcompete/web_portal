<?php
/**
 * Created by PhpStorm.
 * User: FenjeR
 * Date: 1/10/14
 * Time: 4:44 PM
 */
class Parentlib{
    private $ci;
    public function __construct(){
        $this->ci = &get_instance();
        $this->ci->load->model('x_users/parent_model');
        $this->ci->load->helper('x_users/parent');
    }
}
