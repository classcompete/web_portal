<?php
/**
 * Created by PhpStorm.
 * User: FenjeR
 * Date: 12/20/13
 * Time: 1:54 PM
 */
class Childlib{
    private $ci;

    public function __construct(){
        $this->ci = &get_instance();
        $this->ci->load->model('p_child/child_model');
        $this->ci->load->helper('p_child/child');
    }
}