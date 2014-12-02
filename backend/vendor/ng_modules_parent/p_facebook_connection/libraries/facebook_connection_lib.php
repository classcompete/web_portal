<?php
/**
 * Created by PhpStorm.
 * User: FenjeR
 * Date: 12/25/13
 * Time: 1:06 PM
 */
class Facebook_connection_lib{
    private $ci;

    public function __construct(){
        $this->ci = &get_instance();
        $this->ci->load->model('p_facebook_connection/facebook_connection_model');
        $this->ci->load->helper('p_facebook_connection/facebook_connection');
    }
}